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
     * @codeCoverageIgnore
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
        $from    = $message->getFrom();
        $content = $message->getBody();
        $tags    = $message->getTags();
        $icon    = $message->getIcon();

        $string = (string) "[MESSENGER] : A message has been sent." . PHP_EOL;
        $string .= "[MESSENGER][FROM] : {$from['name']}" . ($from['email'] != "" ? "[{$from['email']}]" : "") . PHP_EOL;
        $string .= "[MESSENGER][CONTENT] : {$content}";

        if ( ! empty($tags) && is_array($tags))
        {
            $string .= PHP_EOL . "[MESSENGER][TAGS] : " . implode(", ", $tags);
        }

        if ( ! is_null($icon))
        {
            $string .= PHP_EOL . "[MESSENGER][ICON] : " . $icon;
        }

        return $string;
    }
}