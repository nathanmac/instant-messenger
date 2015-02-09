<?php namespace Nathanmac\InstantMessenger;

class Message {

    /**
     * The contents of the message to be sent
     *
     * @var string
     */
    protected $body = '';

    /**
     * This contains the name and email of the sender.
     *  (Only supported by selected services)
     *
     * @var array
     */
    protected $from = array('name' => 'api', 'email' => '');

    /**
     * Set the from details of the message
     *  (inc. name and email)
     *
     * @param string $name
     * @param string $email
     * @return $this
     */
    public function from($name, $email = '')
    {
        $this->from = array(
            'name' => $name,
            'email' => $email
        );
        return $this;
    }

    /**
     * Fetch the from details of the message.
     *  (inc. name and email)
     *
     * @return array
     */
    public function getFrom()
    {
        return $this->from;
    }

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
