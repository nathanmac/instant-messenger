<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

class SlackService extends HTTPService implements MessengerService {

    /**
     * The web hook for the Slack service.
     *
     * @var string
     */
    protected $webHook;

    /**
     * The channel for the Slack service.
     *
     * @var null|string
     */
    protected $channel;

    /**
     * Setup the transporter for the Slack service.
     *
     * @param string      $webHook
     * @param null|string $channel
     */
    public function __construct($webHook, $channel = null)
    {
        $this->webHook = $webHook;
        $this->channel = $channel;
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

        $client->post($this->webHook, array('json' => $this->buildMessage($message)));
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

        if ( ! $this->channel)
            $msg['channel'] = $this->channel;

        return $msg;
    }

    /**
     * Get the WebHook being used by the transport.
     *
     * @return string
     */
    public function getWebHook()
    {
        return $this->webHook;
    }

    /**
     * Set the WebHook being used by the transport.
     *
     * @param  string  $webHook
     *
     * @return $this
     */
    public function setWebHook($webHook)
    {
        $this->webHook = $webHook;
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
}