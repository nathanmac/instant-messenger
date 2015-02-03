<?php

namespace spec\Nathanmac\InstantMessenger;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Message');
    }

    function it_sets_the_messages_body()
    {
        $message = "This is a simple notification message";
        $this->body($message);
        $this->getBody()->shouldReturn($message);
    }
}
