<?php

namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Nathanmac\InstantMessenger\Services\FlowDockService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;

class FlowDockServiceSpec extends ObjectBehavior
{
    function let(GuzzleHttp\Client $client)
    {
        $this->beAnInstanceOf('spec\Nathanmac\InstantMessenger\Services\FlowDockServiceStub');
        $this->beConstructedWith('token');

        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\FlowDockService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_sends_a_messages($client)
    {
        // Create a new message.
        $message = new Message();
        $message->from('API BOT');
        $message->body("Simple notification message.");

        $client->post("https://api.flowdock.com/v1/messages/chat/token",
            array(
                "json" => array(
                    "external_user_name" => "APIBOT",
                    "content" => "Simple notification message."
                )
            )
        )->shouldBeCalled();

        $this->send($message);


        // Send message with added tags.
        $message->tags('one', 'two', 'three');

        $client->post("https://api.flowdock.com/v1/messages/chat/token",
            array(
                "json" => array(
                    "external_user_name" => "APIBOT",
                    "content" => "Simple notification message.",
                    "tags" => array('one', 'two', 'three')
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

    function it_adds_an_array_of_tags()
    {
        // Get the current list of tags
        $this->getTags()->shouldReturn([]);

        // Set the current tags
        $this->setTags(['one', 'two', 'three']);

        //Get the current list of tags
        $this->getTags()
            ->shouldReturn(['one', 'two', 'three']);
    }

    function it_should_throw_an_exception_if_the_tags()
    {
        // Throw an exception if the tags parameter is not valid.
        $this->shouldThrow(new \InvalidArgumentException("setTags function only accepts an array of strings."))
            ->during('setTags', array('random in valid parameter'));
    }
}

class FlowDockServiceStub extends FlowDockService {

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