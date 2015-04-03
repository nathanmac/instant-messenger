<?php

namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Nathanmac\InstantMessenger\Services\SqwiggleService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;

class SqwiggleServiceSpec extends ObjectBehavior
{
    function let(GuzzleHttp\Client $client)
    {
        $this->beAnInstanceOf('spec\Nathanmac\InstantMessenger\Services\SqwiggleServiceStub');
        $this->beConstructedWith('token', 123456);

        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\SqwiggleService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_sends_a_messages($client)
    {
        // Create a new message.
        $message = new Message();
        $message->from('API');
        $message->body("Simple notification message.");

        $client->post("https://api.sqwiggle.com/messages",
            array(
                "auth" => array("token", "X"),
                "json" => array(
                    "text" => "Simple notification message.",
                    "stream_id" => 123456
                )
            )
        )->shouldBeCalled();

        $this->send($message);
    }

    function it_gets_and_sets_the_token()
    {
        // Get the current token
        $this->getToken()->shouldReturn('token');

        // Set the token
        $this->setToken('newtoken');

        // Get the current token
        $this->getToken()->shouldReturn('newtoken');
    }

    function it_gets_and_sets_the_stream()
    {
        // Get the current stream
        $this->getStream()->shouldReturn(123456);

        // Set the stream
        $this->setStream(654321);

        // Get the current stream
        $this->getStream()->shouldReturn(654321);
    }
}

class SqwiggleServiceStub extends SqwiggleService {

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