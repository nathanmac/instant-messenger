<?php namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Nathanmac\InstantMessenger\Services\HipChatService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;

class HipChatServiceSpec extends ObjectBehavior
{

    function let(GuzzleHttp\Client $client)
    {
        $this->beAnInstanceOf('spec\Nathanmac\InstantMessenger\Services\HipChatServiceStub');
        $this->beConstructedWith('apikey', 123456);

        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HipChatService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_sends_a_messages($client)
    {
        // Create a new message.
        $message = new Message();
        $message->body("Simple notification message.");

        $client->post("https://api.hipchat.com/v2/room/123456/notification?auth_token=apikey",
            array(
                "json" => array(
                    "message" => "Simple notification message.",
                    "notify" => true,
                    "color" => "yellow"
                )
            )
        )->shouldBeCalled();

        $this->send($message);
    }

    function it_gets_and_sets_the_room_id()
    {
        // Get the current room id
        $this->getRoom()->shouldReturn(123456);

        // Set the room id
        $this->setRoom(654321);

        // Get the current room id
        $this->getRoom()->shouldReturn(654321);
    }

    function it_gets_and_sets_the_key()
    {
        // Get the current key
        $this->getKey()->shouldReturn('apikey');

        // Set the api key
        $this->setKey('keyapi');

        // Get the current key
        $this->getKey()->shouldReturn('keyapi');
    }

    function it_gets_and_sets_the_notify_option()
    {
        // Get the current notify status
        $this->doNotify()->shouldReturn(true);

        // Set the api key
        $this->setNotify(false);

        // Get the current notify status
        $this->doNotify()->shouldReturn(false);
    }

    function it_gets_and_sets_the_color_option()
    {
        // Get the current color setting
        $this->getColor()->shouldReturn('yellow');

        // Set the color key
        $this->setColor('random');

        // Get the current color setting
        $this->getColor()->shouldReturn('random');
    }
}

class HipChatServiceStub extends HipChatService {

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