<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

class HallService extends HTTPService implements MessengerService {

    /**
     * The token for the Hall service.
     *
     * @var string
     */
    protected $token;

    /**
     * The API endpoint.
     *
     * @var string
     */
    private $api_endpoint = 'https://hall.com/api/1/services/generic/';

    /**
     * Setup the transporter for the Hall service.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Create a new HallService instance.
     *
     * @param $token
     *
     * @return HallService
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

        $url = $this->api_endpoint . $this->token;
        $client->post($url, array('json' => $this->buildMessage($message)));
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
            'title' => $message->getFrom()['name'],
            'message' => $message->getBody()
        );

        if ($message->getIcon())
            $msg['picture'] = $message->getIcon();

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
}