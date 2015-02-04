<?php namespace spec\Nathanmac\InstantMessenger;

use Illuminate\Contracts\Events\Dispatcher;
use Nathanmac\InstantMessenger\Services\MessengerService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Log\LoggerInterface;

class MessengerSpec extends ObjectBehavior
{
    function let(MessengerService $service, Dispatcher $dispatcher)
    {
        $this->beConstructedWith($service, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Messenger');
    }

    function it_fires_an_event_on_sending_of_message($service, $dispatcher)
    {
        // Create the expected message object
        $message = new \Nathanmac\InstantMessenger\Message();
        $message->body('This is a test notification');

        // Event should be fired with message being sent
        $dispatcher->fire('messenger.sending', array($message))->shouldBeCalled();

        $service->send($message)->shouldBeCalled();

        // Send a message
        $this->send(function ($message) {
            $message->body('This is a test notification');
        });
    }

    function it_logs_the_message_on_sending_of_a_message(LoggerInterface $logger)
    {
        // Turn on pretending to enable logging
        $this->pretend(true);

        // Inject the logger
        $this->setLogger($logger);

        $logger->info("Pretending to send instant message: This is a test notification")->shouldBeCalled();

        // Send a message
        $this->send(function ($message) {
            $message->body('This is a test notification');
        });
    }

    function it_sets_pretending_option()
    {
        // Pretending should be false by default.
        $this->isPretending()->shouldReturn(false);

        // Set pretending to true.
        $this->pretend(true);
        $this->isPretending()->shouldReturn(true);

        // Set pretending to false.
        $this->pretend(false);
        $this->isPretending()->shouldReturn(false);
    }
}
