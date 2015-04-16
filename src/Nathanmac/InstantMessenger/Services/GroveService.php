<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

class GroveService extends HTTPService implements MessengerService {

    /**
     * The token for the Grove service.
     *
     * @var string
     */
    protected $token;

    /**
     * The icon for the message.
     *
     * @var string
     */
    protected $icon = null;

    /**
     * The API endpoint.
     *
     * @var string
     */
    private $api_endpoint = 'https://grove.io/api/notice/';

    /**
     * Setup the transporter for the Grove service.
     *
     * @param string $token
     * @param string|null $icon
     */
    public function __construct($token, $icon = null)
    {
        $this->token = $token;
        $this->icon = $icon;
    }

    /**
     * Create a new GroveService instance.
     *
     * @codeCoverageIgnore
     *
     * @param $token
     * @param string|null $icon
     *
     * @return GroveService
     */
    public static function newInstance($token, $icon = null)
    {
        return new self($token, $icon);
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
        $client->post($url, array('body' => $this->buildMessage($message)));
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
            'service' => str_replace(" ", "", $message->getFrom()['name']),
            'message' => $message->getBody()
        );

        if (null !== $this->getIcon())
            $msg['icon_url'] = $this->getIcon();

        if (null !== $message->getIcon())
            $msg['icon_url'] = $message->getIcon();

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
     * @param  string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the image for the message.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the icon for the message.
     *
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
        return $this;
    }
}