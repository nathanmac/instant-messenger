<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Exception;

class TwilioService extends HTTPService implements MessengerService {

    /**
     * The account sid for the Twilio service.
     *
     * @var string
     */
    private $account_sid;

    /**
     * The auth token for the Twilio service.
     *
     * @var string
     */
    private $auth_token;

    /**
     * The phone number to send to, for the Twilio service.
     *
     * @var string|null
     */
    private $to = null;

    /**
     * The phone number to send from, for the Twilio service.
     *
     * @var string
     */
    private $from;

    /**
     * The API endpoint for the Twilio service.
     *
     * @var string
     */
    private $api_endpoint = 'https://api.twilio.com/2010-04-01/Accounts/';

    /**
     * Setup the transporter for the Twilio service.
     *
     * @param string      $account_sid Twilio Account SID
     * @param string      $auth_token  Twilio Auth Token
     * @param string      $from        Twilio From Number
     * @param string|null $to          Twilio To Number
     */
    public function __construct($account_sid, $auth_token, $from, $to = null)
    {
        $this->account_sid = $account_sid;
        $this->auth_token = $auth_token;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Create a new TwilioService instance.
     *
     * @codeCoverageIgnore
     *
     * @param string      $account_sid Twilio Account SID
     * @param string      $auth_token  Twilio Auth Token
     * @param string      $from        Twilio From Number
     * @param string|null $to          Twilio To Number
     *
     * @return TwilioService
     */
    public static function newInstance($account_sid, $auth_token, $from, $to = null)
    {
        return new self($account_sid, $auth_token, $from, $to);
    }

    /**
     * Send/Transmit the message using the service.
     *
     * @param Message $message
     *
     * @return mixed|void
     *
     * @throws Exception
     */
    public function send(Message $message)
    {
        if (null === $this->getTo() || '' === $this->getTo())
            throw new Exception('Missing phone number');

        $client = $this->getHttpClient();

        $url = $this->api_endpoint . $this->getAccountSid() . '/Messages.json';
        $client->post($url, array('auth' => array($this->getAccountSid(), $this->getAuthToken()), 'form_params' => $this->buildMessage($message)));
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
            'Body' => $message->getBody(),
            'To' => $this->getTo(),
            'From' => $this->getFrom()
        );

        return $msg;
    }

    /**
     * Get the account sid being used by the transport.
     *
     * @return string
     */
    public function getAccountSid()
    {
        return $this->account_sid;
    }

    /**
     * Set the account sid being used by the transport.
     *
     * @param string $account_sid
     *
     * @return $this
     */
    public function setAccountSid($account_sid)
    {
        $this->account_sid = $account_sid;
        return $this;
    }

    /**
     * Get the auth token being used by the transport.
     *
     * @return string
     */
    public function getAuthToken()
    {
        return $this->auth_token;
    }

    /**
     * Set the auth token being used by the transport.
     *
     * @param string $auth_token
     *
     * @return $this
     */
    public function setAuthToken($auth_token)
    {
        $this->auth_token = $auth_token;
        return $this;
    }

    /**
     * Get the to number being used by the transport.
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set the to number being used by the transport.
     *
     * @param string $to
     *
     * @return $this
     */
    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Get the from number being used by the transport.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set the from number being used by the transport.
     *
     * @param string $from
     *
     * @return $this
     */
    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }
}