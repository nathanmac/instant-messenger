<?php namespace spec\Nathanmac\InstantMessenger\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SlackServiceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('webhook', '#channel');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\SlackService');
    }

    function it_sends_a_message()
    {
        // Create the expected message object
        $message = new \Nathanmac\InstantMessenger\Message();
        $message->body('This is a test notification');

        //$this->send($message);
    }

    function it_gets_and_sets_the_web_hook()
    {
        // Get the current key
        $this->getWebHook()->shouldReturn('webhook');

        // Set the api key
        $this->setWebHook('hookweb');

        // Get the current key
        $this->getWebHook()->shouldReturn('hookweb');
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
