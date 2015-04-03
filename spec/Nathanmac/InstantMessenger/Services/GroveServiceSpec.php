<?php

namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Nathanmac\InstantMessenger\Services\GroveService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;

class GroveServiceSpec extends ObjectBehavior
{
    function let(GuzzleHttp\Client $client)
    {
        $this->beAnInstanceOf('spec\Nathanmac\InstantMessenger\Services\GroveServiceStub');
        $this->beConstructedWith('token');

        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\GroveService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_sends_a_messages($client)
    {
        // Create a new message.
        $message = new Message();
        $message->from("API");
        $message->body("Simple notification message.");

        $client->post("https://grove.io/api/notice/token",
            array(
                "body" => array(
                    "service" => "API",
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

    function it_gets_and_sets_the_icon()
    {
        // Get the current key
        $this->getIcon()->shouldReturn(null);

        // Set the api key
        $this->setIcon('iconurl');

        // Get the current key
        $this->getIcon()->shouldReturn('iconurl');
    }
}

class GroveServiceStub extends GroveService {

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