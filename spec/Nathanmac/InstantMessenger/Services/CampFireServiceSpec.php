<?php

namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Nathanmac\InstantMessenger\Services\CampFireService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;

class CampFireServiceSpec extends ObjectBehavior
{
    function let(GuzzleHttp\Client $client)
    {
        $this->beAnInstanceOf('spec\Nathanmac\InstantMessenger\Services\CampFireServiceStub');
        $this->beConstructedWith('subdomain', 'token', 'room');

        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\CampFireService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_sends_a_messages($client)
    {
        // Create a new message.
        $message = new Message();
        $message->body("Simple notification message.");

        $client->post("https://subdomain.campfirenow.com/room/room/speak.xml",
            array(
                "auth" => array('token', 'X'),
                'headers' => array('Content-Type' => 'application/xml'),
                "body" => "<message><type>TextMessage</type><body>Simple notification message.</body></message>"
            )
        )->shouldBeCalled();

        $this->send($message);
    }

    function it_gets_and_sets_the_subdomain()
    {
        // Get the current subdomain
        $this->getSubdomain()->shouldReturn('subdomain');

        // Set the subdomain
        $this->setSubdomain('newsubdomain');

        // Get the current subdomain
        $this->getSubdomain()->shouldReturn('newsubdomain');
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

    function it_gets_and_sets_the_room()
    {
        // Get the current room
        $this->getRoom()->shouldReturn('room');

        // Set the room
        $this->setRoom('newroom');

        // Get the current room
        $this->getRoom()->shouldReturn('newroom');
    }
}

class CampFireServiceStub extends CampFireService {

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