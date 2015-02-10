<?php namespace spec\Nathanmac\InstantMessenger\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HipChatServiceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('apikey', 123456);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HipChatService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
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
}
