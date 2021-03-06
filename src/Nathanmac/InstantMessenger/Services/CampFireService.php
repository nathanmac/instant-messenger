<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

class CampFireService extends HTTPService implements MessengerService {

    /**
     * The token for the CampFire service.
     *
     * @var string
     */
    protected $token;

    /**
     * The room for the CampFire service.
     *
     * @var string
     */
    protected $room;

    /**
     * The sub-domain for the CampFire service.
     *
     * @var string
     */
    protected $subDomain;

    /**
     * Setup the transporter for the CampFire service.
     *
     * @param string $subDomain
     * @param string $token
     * @param string $room
     */
    public function __construct($subDomain, $token, $room)
    {
        $this->subDomain = $subDomain;
        $this->token     = $token;
        $this->room      = $room;
    }

    /**
     * Create a new CampFireService instance.
     *
     * @codeCoverageIgnore
     *
     * @param $subDomain
     * @param $token
     * @param $room
     *
     * @return CampFireService
     */
    public static function newInstance($subDomain, $token, $room)
    {
        return new self($subDomain, $token, $room);
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

        $url = 'https://' . $this->subDomain . '.campfirenow.com/room/' . $this->room . '/speak.xml';
        $client->post($url, array('auth' => array($this->token, 'X'), 'headers' => array('Content-Type' => 'application/xml'), 'body' => $this->buildMessage($message)));
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
        return "<message><type>TextMessage</type><body>{$message->getBody()}</body></message>";
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
     * Get the room being used by the transport.
     *
     * @return string
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set the token being used by the transport.
     *
     * @param string $room
     * @return $this
     */
    public function setRoom($room)
    {
        $this->room = $room;
        return $this;
    }

    /**
     * Get the sub domain being used by the transport.
     *
     * @return string
     */
    public function getSubDomain()
    {
        return $this->subDomain;
    }

    /**
     * Set the sub domain being used by the transport.
     *
     * @param string $subDomain
     *
     * @return $this
     */
    public function setSubDomain($subDomain)
    {
        $this->subDomain = $subDomain;
        return $this;
    }
}