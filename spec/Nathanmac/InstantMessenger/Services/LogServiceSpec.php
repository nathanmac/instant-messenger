<?php

namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

class LogServiceSpec extends ObjectBehavior
{
    function let(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\LogService');
    }

    function it_sends_a_message_to_the_logger($logger)
    {
        $message = new Message();
        $message->from('API');
        $message->body("Simple notification message.");

        $logger->debug(
            "[MESSENGER] : A message has been sent." . PHP_EOL .
            "[MESSENGER][FROM] : API" . PHP_EOL .
            "[MESSENGER][CONTENT] : Simple notification message."
        )->shouldBeCalled();

        $this->send($message);

        // Send message with an added icon image and tags.
        $message->icon('http://img.com');
        $message->tags('one', 'two', 'three');

        $logger->debug(
            "[MESSENGER] : A message has been sent." . PHP_EOL .
            "[MESSENGER][FROM] : API" . PHP_EOL .
            "[MESSENGER][CONTENT] : Simple notification message." . PHP_EOL .
            "[MESSENGER][TAGS] : one, two, three" . PHP_EOL .
            "[MESSENGER][ICON] : http://img.com"
        )->shouldBeCalled();

        $this->send($message);
    }
}
