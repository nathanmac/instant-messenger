<?php namespace spec\Nathanmac\InstantMessenger\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlackServiceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('token', '#channel');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\SlackService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_gets_and_sets_the_token()
    {
        // Get the current key
        $this->getToken()->shouldReturn('token');

        // Set the api key
        $this->setToken('newtoken');

        // Get the current key
        $this->getToken()->shouldReturn('newtoken');
    }

    function it_gets_and_sets_the_channel()
    {
        // Get the current key
        $this->getChannel()->shouldReturn('#channel');

        // Set the api key
        $this->setChannel('#channel');

        // Get the current key
        $this->getChannel()->shouldReturn('#channel');
    }
}
