<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

class SlackService extends HTTPService implements MessengerService {

    /**
     * The token for the Slack service.
     *
     * @var string
     */
    protected $token;

    /**
     * The channel for the Slack service.
     *
     * @var null|string
     */
    protected $channel;

    /**
     * The icon for the message.
     *
     * @var string
     */
    protected $icon = null;

    /**
     * The API endpoint for the Slack service.
     *
     * @var string
     */
    private $api_endpoint = 'https://hooks.slack.com/services/';

    /**
     * Setup the transporter for the Slack service.
     *
     * @param string $token
     * @param null|string $channel
     * @param string|null $icon
     */
    public function __construct($token, $channel = null, $icon = null)
    {
        $this->token = $token;
        $this->channel = $channel;
        $this->icon = $icon;
    }

    /**
     * Create a new SlackService instance.
     *
     * @codeCoverageIgnore
     *
     * @param $token
     * @param string|null $channel
     * @param string|null $icon
     *
     * @return SlackService
     */
    public static function newInstance($token, $channel = null, $icon = null)
    {
        return new self($token, $channel, $icon);
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
            'text' => $message->getBody(),
            'username' => $message->getFrom()['name']
        );

        if (null !== $this->getIcon())
            $msg['icon_url'] = $this->getIcon();

        if (null !== $message->getIcon())
            $msg['icon_url'] = $message->getIcon();

        if (null !== $this->channel)
            $msg['channel'] = $this->channel;

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
     * Get the channel being used by the transport.
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Set the channel being used by the transport.
     *
     * @param  string  $channel
     *
     * @return $this
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
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