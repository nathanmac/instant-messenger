<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

/**
 * Class TelegramService
 *
 * @package Nathanmac\InstantMessenger\Services
 */
class TelegramService extends HTTPService implements MessengerService {

    /**
     * The token for the Telegram service.
     *
     * @var string
     */
    protected $token;

    /**
     * The chat id of the Telegram bot.
     *
     * @var string
     */
    protected $chat_id;

    /**
     * The API endpoint for the Telegram service.
     *
     * @var string
     */
    private $api_endpoint = 'https://api.telegram.org/';

    /**
     * Setup the transporter for the Telegram service.
     *
     * @param string $token
     * @param string $chat_id
     */
    public function __construct($token, $chat_id)
    {
        $this->token = $token;
        $this->chat_id = $chat_id;
    }

    /**
     * Create a new TelegramService instance.
     *
     * @codeCoverageIgnore
     *
     * @param string $token
     * @param string $chat_id
     *
     * @return TelegramService
     */
    public static function newInstance($token, $chat_id)
    {
        return new self($token, $chat_id);
    }

    /**
     * Send/Transmit the message using the service.
     *
     * @param Message $message
     *
     * @return void
     */
    public function send(Message $message)
    {
        $client = $this->getHttpClient();

        $url = $this->api_endpoint . 'bot' . $this->token . '/sendMessage';
        $client->post($url, array('form_params' => $this->buildMessage($message)));
    }

    /**
     * Construct message ready for formatting and transmission.
     *
     * @param Message $message
     *
     * @return array
     */
    protected function buildMessage(Message $message)
    {
        $msg = array(
            'text' => $message->getBody(),
            'chat_id' => $this->getChatId()
        );

        return $msg;
    }

    /**
     * Get the token being used by the transport.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the token being used by the transport.
     *
     * @param  string  $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Get the Chat ID being used by the transport.
     *
     * @return string
     */
    public function getChatId()
    {
        return $this->chat_id;
    }

    /**
     * Set the Chat ID being used by the transport
     *
     * @param string $chat_id
     */
    public function setChatId($chat_id)
    {
        $this->chat_id = $chat_id;
    }
}