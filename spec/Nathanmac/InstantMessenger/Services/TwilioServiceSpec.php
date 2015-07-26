<?php namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Nathanmac\InstantMessenger\Services\TwilioService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;

class TwilioServiceSpec extends ObjectBehavior
{
    function let(GuzzleHttp\Client $client)
    {
        $this->beAnInstanceOf('spec\Nathanmac\InstantMessenger\Services\TwilioServiceStub');
        $this->beConstructedWith('account_sid', 'auth_token', '0123456789');

        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\TwilioService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_throws_an_exception_with_missing_to_phone_number()
    {
        // Create a new message.
        $message = new Message();
        $message->body("Simple notification message.");

        $this->shouldThrow(new \Exception("Missing phone number"))->during('send', array($message));
    }

    function it_sends_a_messages($client)
    {
        // Create a new message.
        $message = new Message();
        $message->body("Simple notification message.");

        $client->post("https://api.twilio.com/2010-04-01/Accounts/account_sid/Messages.json",
            array(
                "auth" => array(
                    "account_sid",
                    "auth_token"
                ),
                "form_params" => array(
                    "Body" => "Simple notification message.",
                    "To" => "0123456789",
                    "From" => "0123456789"
                )
            )
        )->shouldBeCalled();

        $this->setTo('0123456789');
        $this->send($message);
    }

    function it_gets_and_sets_the_account_sid()
    {
        // Get the account sid
        $this->getAccountSid()->shouldReturn('account_sid');

        // Set the account sid
        $this->setAccountSid('newaccount_sid');

        // Get the account sid
        $this->getAccountSid()->shouldReturn('newaccount_sid');
    }

    function it_gets_and_sets_the_auth_token()
    {
        // Get the auth token
        $this->getAuthToken()->shouldReturn('auth_token');

        // Set the auth token
        $this->setAuthToken('newauth_token');

        // Get the auth token
        $this->getAuthToken()->shouldReturn('newauth_token');
    }

    function it_gets_and_sets_the_to_phone_number()
    {
        // Get the to phone number
        $this->getTo()->shouldReturn(null);

        // Set the to phone number
        $this->setTo('0987654321');

        // Get the to phone number
        $this->getTo()->shouldReturn('0987654321');
    }

    function it_gets_and_sets_the_from_phone_number()
    {
        // Get the from phone number
        $this->getFrom()->shouldReturn('0123456789');

        // Set the from phone number
        $this->setFrom('0987654321');

        // Get the from phone number
        $this->getFrom()->shouldReturn('0987654321');
    }
}

class TwilioServiceStub extends TwilioService {

    public $client;

    public function setHttpClient($client)
    {
        $this->client = $client;
    }

    public function getHttpClient()
    {
        return $this->client;
    }
}