<?php namespace Nathanmac\InstantMessenger;

class Message {

    /**
     * The contents of the message to be sent.
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
     * Any tags to be added to the message.
     *  (Only supported by selected services)
     *
     * @var array
     */
    protected $tags = array();

    /**
     * The icon image use as part of the message.
     *  (Only supported by selected services)
     *
     * @var string|null
     */
    protected $icon = null;

    /**
     * Set the from details of the message.
     *  (inc. name and email)
     *
     * @param string $name
     * @param string $email
     *
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
     * Set the body of the message.
     *
     * @param $body
     *
     * @return $this
     */
    public function body($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Alias for the body message.
     *
     * @alias body
     *
     * @param $body
     *
     * @return Message
     */
    public function content($body)
    {
        return $this->body($body);
    }

    /**
     * Fetch the body of the message.
     *
     * @return string
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * Alias for the Fetch the body of the message.
     *
     * @alias getBody
     *
     * @return string
     */
    public function getContent() {
        return $this->getBody();
    }

    /**
     * Set/Add a single tag to the message.
     *
     * @param string $tag
     * @return $this
     */
    public function tag($tag)
    {
        array_push($this->tags, $tag);
        return $this;
    }

    /**
     * Set the tags for the message.
     *
     * @param array $tags
     *
     * @return $this
     */
    public function tags($tags = array())
    {
        if (is_array($tags))
            $this->tags = array_merge($this->tags, $tags);
        else
            $this->tags = array_merge($this->tags, func_get_args());

        return $this;
    }

    /**
     * Fetch the tags for the message.
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set the icon for the message.
     *
     * @param null|string $icon
     *
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Get the icon for the message.
     *
     * @return null|string
     */
    public function getIcon()
    {
        return $this->icon;
    }
}
