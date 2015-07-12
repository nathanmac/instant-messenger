<?php namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Nathanmac\InstantMessenger\Services\TelegramService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;

class TelegramServiceSpec extends ObjectBehavior
{
    function let(GuzzleHttp\Client $client)
    {
        $this->beAnInstanceOf('spec\Nathanmac\InstantMessenger\Services\TelegramServiceStub');
        $this->beConstructedWith('token', 123456);

        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\TelegramService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_sends_a_messages($client)
    {
        // Create a new message.
        $message = new Message();
        $message->body("Simple notification message.");

        $client->post("https://api.telegram.org/bottoken/sendMessage",
            array(
                "form_params" => array(
                    "text" => "Simple notification message.",
                    "chat_id" => 123456
                )
            )
        )->shouldBeCalled();

        $this->send($message);
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

    function it_gets_and_sets_the_chat_id()
    {
        // Get the chat id
        $this->getChatId()->shouldReturn(123456);

        // Set the chat id
        $this->setChatId(654321);

        // Get the chat id
        $this->getChatId()->shouldReturn(654321);
    }
}

class TelegramServiceStub extends TelegramService {

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