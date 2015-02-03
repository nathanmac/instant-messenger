<?php namespace Nathanmac\InstantMessenger;

class Message {

    /**
     * The contents of the message to be sent
     *
     * @var string
     */
    protected $body;

    /**
     * Set the body of the message
     *
     * @param $body
     * @return $this
     */
    public function body($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Fetch the body of the message
     *
     * @return string
     */
    public function getBody() {
        return $this->body;
    }
}
