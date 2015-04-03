<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

class GitterService extends HTTPService implements MessengerService {

    /**
     * @var string
     */
    protected $token;

    /**
     * The API endpoint.
     *
     * @var string
     */
    private $api_endpoint = 'https://webhooks.gitter.im/e/';

    /**
     * Setup the transporter
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Create a new GitterService instance.
     *
     * @codeCoverageIgnore
     *
     * @param $token
     *
     * @return GitterService
     */
    public static function newInstance($token)
    {
        return new self($token);
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

        $client->post($this->api_endpoint . $this->token, array('json' => $this->buildMessage($message)));
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
        return array(
            'message' => $message->getBody()
        );
    }

    /**
     * Get the Token being used by the transport.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the Token being used by the transport.
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
}