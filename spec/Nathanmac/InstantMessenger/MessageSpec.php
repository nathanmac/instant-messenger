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

    function it_sets_the_messages_from()
    {
        // Set just the name
        $this->from('John Smith');
        $this->getFrom()->shouldReturn(array('name' => 'John Smith', 'email' => ''));

        // Set the name and the email address
        $this->from('John Smith', 'john.smith@example.com');
        $this->getFrom()->shouldReturn(array('name' => 'John Smith', 'email' => 'john.smith@example.com'));
    }
}
