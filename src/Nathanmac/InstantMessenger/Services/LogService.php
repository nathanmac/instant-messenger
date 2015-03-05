<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Psr\Log\LoggerInterface;

class LogService implements MessengerService {

    /**
     * The Logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create a new log transport instance.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Create a new LogService instance.
     *
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return LogService
     */
    public static function newInstance(LoggerInterface $logger)
    {
        return new self($logger);
    }

    /**
     * Send message to the external service
     *
     * @param Message $message
     * @return mixed
     */
    public function send(Message $message)
    {
        $this->logger->debug($this->buildMessage($message));
    }

    /**
     * Construct message ready for formatting and transmission.
     *
     * @param Message $message
     *
     * @return string
     */
    protected function buildMessage(Message $message)
    {
        $from = $message->getFrom();
        $content = $message->getBody();

        // Auto Notifier : Hello this is a simple notification.
        // John Smith [john.smith@example.com] : Hello this is a simple notification.
        return "{$from['name']}" . ($from['email'] != "" ? "[{$from['email']}]" : "") . " : {$content}";
    }
}