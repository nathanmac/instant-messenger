<?php namespace Nathanmac\InstantMessenger;

use Closure;
use Psr\Log\LoggerInterface;
use InvalidArgumentException;
use Illuminate\Contracts\Events\Dispatcher;
use Nathanmac\InstantMessenger\Services\MessengerService;
use Nathanmac\InstantMessenger\Contracts\Messenger as MessengerContract;
use Nathanmac\InstantMessenger\Contracts\MessengerQueue as MessengerQueueContract;

class Messenger implements MessengerContract {

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
     * @return void
     */
    public function send($callback)
    {
        $data['message'] = $message = $this->createMessage();

        $this->callMessageBuilder($callback, $message);

        $this->sendMessage($message);
    }

    /**
     * Call the provided message builder.
     *
     * @param  \Closure|string  $callback
     * @param  \Nathanmac\InstantMessenger\Message $message
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
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

}