<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

class HipChatService extends HTTPService implements MessengerService {

    /**
     * The authentication key/token for the HipChat service.
     *
     * @var string
     */
    protected $key;

    /**
     * The room id for the HipChat service.
     *
     * @var int
     */
    protected $room;

    /**
     * The notification setting for the HipChat service.
     *
     * @var bool
     */
    protected $notify;

    /**
     * Optional set the colour of the message.
     *  (Defaults to yellow)
     *
     * @var string
     */
    protected $color = self::COLOR_YELLOW;

    /**
     * Colors
     */
    const COLOR_YELLOW = 'yellow';
    const COLOR_GREEN = 'green';
    const COLOR_RED = 'red';
    const COLOR_PURPLE = 'purple';
    const COLOR_GRAY = 'gray';
    const COLOR_RANDOM = 'random';

    /**
     * Setup the transporter for the HipChat service.
     *
     * @param string $key
     * @param int    $room
     * @param bool   $notify
     */
    public function __construct($key, $room, $notify = true)
    {
        $this->key = $key;
        $this->room = $room;
        $this->notify = $notify;
    }

    public function send(Message $message)
    {
        $client = $this->getHttpClient();

        // Build the uri for the request
        $url = "https://api.hipchat.com/v2/room/" . $this->room . "/notification?auth_token=" . $this->key;

        return $client->post($url, array('json' => $this->buildMessage($message)));
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
            'message' => $message->getBody(),
            'notify' => $this->notify,
            'color' => $this->color
        );
    }

    /**
     * Get the API key being used by the transport.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the API key being used by the transport.
     *
     * @param  string  $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Get the notification status being used by the transport.
     *
     * @return string
     */
    public function doNotify()
    {
        return $this->notify;
    }

    /**
     * Set the notification status being used by the transport.
     *
     * @param  bool  $notify
     *
     * @return $this
     */
    public function setNotify($notify)
    {
        $this->notify = $notify;
        return $this;
    }

    /**
     * Get the Room ID being used by the transport.
     *
     * @return int
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Set the Room ID being used by the transport.
     *
     * @param  string  $room
     *
     * @return $this
     */
    public function setRoom($room)
    {
        $this->room = $room;
        return $this;
    }

    /**
     * Returns the background color for the messsage.
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Sets the background color for the message.
     *
     * @param string $color
     * @return $this
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }
}