<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

class SlackService extends HTTPService implements MessengerService {

    protected $webHook;

    protected $channel;

    /**
     * Setup the transporter
     *
     * @param string $webHook
     * @param bool   $channel
     */
    public function __construct($webHook, $channel = false)
    {
        $this->webHook = $webHook;
        $this->channel = $channel;
    }

    /**
     * Send/Transmit the message using the service.
     *
     * @param Message $message
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
     * @return void
     */
    public function setWebHook($webHook)
    {
        return $this->webHook = $webHook;
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
     * @return void
     */
    public function setChannel($channel)
    {
        return $this->channel = $channel;
    }
}