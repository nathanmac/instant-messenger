<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

class FlowDockService extends HTTPService implements MessengerService {

    /**
     * The token for the FlowDock service.
     *
     * @var string
     */
    protected $token;

    /**
     * The tags for the FlowDock message.
     *
     * @var array
     */
    protected $tags = array();

    /**
     * The API endpoint.
     *
     * @var string
     */
    private $api_endpoint = 'https://api.flowdock.com/v1/messages/chat/';

    /**
     * Setup the transporter for the FlowDock service.
     *
     * @param string $token
     * @param array $tags
     */
    public function __construct($token, $tags = array())
    {
        $this->token = $token;
        $this->tags = $tags;
    }

    /**
     * Create a new FlowDockService instance.
     *
     * @param string $token
     * @param array $tags
     *
     * @return FlowDockService
     */
    public static function newInstance($token, $tags = array())
    {
        return new self($token, $tags);
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
            'external_user_name' => str_replace(" ", "", $message->getFrom()['name']),
            'content' => $message->getBody()
        );

        if (is_array($this->tags) && !empty($this->tags))
            $msg['tags'] = $this->tags;

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
     * Get the tags being sent in the message.
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set the tags for the message being sent.
     *
     * @param array $tags
     *
     * @return $this
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

}