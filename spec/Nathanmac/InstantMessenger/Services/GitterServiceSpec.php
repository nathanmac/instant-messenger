<?php

namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Nathanmac\InstantMessenger\Services\GitterService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;

class GitterServiceSpec extends ObjectBehavior
{
    function let(GuzzleHttp\Client $client)
    {
        $this->beAnInstanceOf('spec\Nathanmac\InstantMessenger\Services\GitterServiceStub');
        $this->beConstructedWith('token');

        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\GitterService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_sends_a_messages($client)
    {
        // Create a new message.
        $message = new Message();
        $message->body("Simple notification message.");

        $client->post("https://webhooks.gitter.im/e/token",
            array(
                "json" => array(
                    "message" => "Simple notification message."
                )
            )
        )->shouldBeCalled();

        $this->send($message);
    }

    function it_gets_and_sets_the_key()
    {
        // Get the current token
        $this->getToken()->shouldReturn('token');

        // Set the token
        $this->setToken('newtoken');

        // Get the current token
        $this->getToken()->shouldReturn('newtoken');
    }
}

class GitterServiceStub extends GitterService {

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
