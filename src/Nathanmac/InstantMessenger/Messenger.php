<?php namespace Nathanmac\InstantMessenger;

use Closure;
use Illuminate\Contracts\Queue\Job;
use Psr\Log\LoggerInterface;
use SuperClosure\Serializer;
use InvalidArgumentException;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Container\Container;
use Nathanmac\InstantMessenger\Services\MessengerService;
use Nathanmac\InstantMessenger\Contracts\Messenger as MessengerContract;
use Nathanmac\InstantMessenger\Contracts\MessengerQueue as MessengerQueueContract;

class Messenger implements MessengerContract, MessengerQueueContract {

    /**
     * The message service.
     *
     * @var MessengerService
     */
    protected $service;

    /**
     * The event dispatcher instance.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * The log writer instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * The IoC container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * The queue implementation.
     *
     * @var \Illuminate\Contracts\Queue\Queue
     */
    protected $queue;

    /**
     * Indicates if the actual sending is disabled.
     *
     * @var bool
     */
    protected $pretending = false;

    /**
     * Create a new Messenger instance.
     *
     * @param  \Nathanmac\InstantMessenger\Services\MessengerService $service
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function __construct(MessengerService $service, Dispatcher $events = null)
    {
        $this->service = $service;
        $this->events = $events;
    }

    /**
     * Send a new instant message.
     *
     * @param  \Closure|string $callback
     *
     * @return void
     */
    public function send($callback)
    {
        $data['message'] = $message = $this->createMessage();

        $this->callMessageBuilder($callback, $message);

        $this->sendMessage($message);
    }

    /**
     * Queue a new instance message for sending.
     *
     * @param  \Closure|string $callback
     * @param  string  $queue
     *
     * @return mixed
     */
    public function queue($callback, $queue = null)
    {
        $callback = $this->buildQueueCallable($callback);

        return $this->queue->push('messenger@handleQueuedMessage', compact('callback'), $queue);
    }

    /**
     * Queue a new message for sending on the given queue.
     *
     * @param  string  $queue
     * @param  \Closure|string  $callback
     *
     * @return mixed
     */
    public function queueOn($queue, $callback)
    {
        return $this->queue($callback, $queue);
    }

    /**
     * Queue a new message for sending after (n) seconds.
     *
     * @param  int  $delay
     * @param  \Closure|string  $callback
     * @param  string  $queue
     *
     * @return mixed
     */
    public function later($delay, $callback, $queue = null)
    {
        $callback = $this->buildQueueCallable($callback);

        return $this->queue->later($delay, 'messenger@handleQueuedMessage', compact('callback'), $queue);
    }

    /**
     * Queue a new message for sending after (n) seconds on the given queue.
     *
     * @param  string  $queue
     * @param  int  $delay
     * @param  \Closure|string  $callback
     *
     * @return mixed
     */
    public function laterOn($queue, $delay, $callback)
    {
        return $this->later($delay, $callback, $queue);
    }

    /**
     * Build the callable for a queued message job.
     *
     * @param  mixed  $callback
     *
     * @return mixed
     */
    protected function buildQueueCallable($callback)
    {
        if ( ! $callback instanceof Closure) return $callback;

        return (new Serializer)->serialize($callback);
    }

    /**
     * Handle a queued message job.
     *
     * @param  \Illuminate\Contracts\Queue\Job  $job
     * @param  array  $data
     *
     * @return void
     */
    public function handleQueuedMessage(Job $job, $data)
    {
        $this->send($this->getQueuedCallable($data));

        $job->delete();
    }

    /**
     * Get the true callable for a queued message.
     *
     * @param  array  $data
     *
     * @return mixed
     */
    protected function getQueuedCallable(array $data)
    {
        if (str_contains($data['callback'], 'SerializableClosure'))
        {
            return unserialize($data['callback'])->getClosure();
        }

        return $data['callback'];
    }

    /**
     * Call the provided message builder.
     *
     * @param  \Closure|string  $callback
     * @param  \Nathanmac\InstantMessenger\Message $message
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    public function callMessageBuilder($callback, $message)
    {
        if ($callback instanceof Closure)
        {
            return call_user_func($callback, $message);
        }
        elseif (is_string($callback))
        {
            return $this->container->make($callback)->messenger($message);
        }

        throw new InvalidArgumentException("Callback is not valid.");
    }

    /**
     * Create a new message instance.
     *
     * @return \Nathanmac\InstantMessenger\Message
     */
    protected function createMessage()
    {
        return new Message();
    }

    protected function sendMessage($message)
    {
        if ($this->events) {
            $this->events->fire('messenger.sending', array($message));
        }

        if ( ! $this->pretending) {
            return $this->service->send($message);
        } elseif (isset($this->logger)) {
            $this->logMessage($message);
        }
    }

    /**
     * Log that a message was sent.
     *
     * @param  Message  $message
     *
     * @return void
     */
    protected function logMessage(Message $message)
    {
        $this->logger->info("Pretending to send instant message: {$message->getBody()}");
    }

    /**
     * Tell the messenger to not really send messages.
     *
     * @param  bool  $value
     *
     * @return void
     */
    public function pretend($value = true)
    {
        $this->pretending = $value;
    }

    /**
     * Check if the messenger is pretending to send messages.
     *
     * @return bool
     */
    public function isPretending()
    {
        return $this->pretending;
    }

    /**
     * Set the log writer instance.
     *
     * @param  \Psr\Log\LoggerInterface  $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Set the queue manager instance.
     *
     * @param  \Illuminate\Contracts\Queue\Queue  $queue
     *
     * @return $this
     */
    public function setQueue(Queue $queue)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * Set the IoC container instance.
     *
     * @param  \Illuminate\Contracts\Container\Container  $container
     *
     * @return void
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Return the messenger service.
     *
     * @return MessengerService
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set the messenger service instance.
     *
     * @param MessengerService $service
     */
    public function setService(MessengerService $service)
    {
        $this->service = $service;
    }
}