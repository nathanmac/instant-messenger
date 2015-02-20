<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

class SqwiggleService extends HTTPService implements MessengerService {

    /**
     * The token for the Sqwiggle service.
     *
     * @var string
     */
    protected $token;

    /**
     * The stream id for the Sqwiggle service.
     *
     * @var int
     */
    protected $stream;

    /**
     * The API endpoint.
     *
     * @var string
     */
    private $api_endpoint = 'https://api.sqwiggle.com/messages';

    /**
     * Setup the transporter for the Sqwiggle service.
     *
     * @param string $token
     * @param int $stream
     */
    public function __construct($token, $stream)
    {
        $this->token = $token;
        $this->stream = $stream;
    }

    /**
     * Create a new SqwiggleService instance.
     *
     * @param string $token
     * @param int $stream
     *
     * @return SqwiggleService
     */
    public static function newInstance($token, $stream)
    {
        return new self($token, $stream);
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

        $client->post($this->api_endpoint, array(
            'auth' => [$this->token, 'X'],
            'json' => $this->buildMessage($message)
        ));
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
            'text' => $message->getBody(),
            'stream_id' => $this->stream
        );
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
     * Get the stream being used by the transport.
     *
     * @return int
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the stream being used by the transport.
     *
     * @param int $stream
     *
     * @return $this
     */
    public function setStream($stream)
    {
        $this->stream = $stream;
        return $this;
    }
}