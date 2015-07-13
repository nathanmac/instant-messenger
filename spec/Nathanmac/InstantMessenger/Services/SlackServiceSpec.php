<?php namespace spec\Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;
use Nathanmac\InstantMessenger\Services\SlackService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp;

class SlackServiceSpec extends ObjectBehavior
{
    function let(GuzzleHttp\Client $client)
    {
        $this->beAnInstanceOf('spec\Nathanmac\InstantMessenger\Services\SlackServiceStub');
        $this->beConstructedWith('token', '#channel');

        $this->setHttpClient($client);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\SlackService');
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\HTTPService');
    }

    function it_sends_a_messages($client)
    {
        // Create a new message.
        $message = new Message();
        $message->from('API');
        $message->body("Simple notification message.");

        $client->post("https://hooks.slack.com/services/token",
            array(
                "json" => array(
                    "username" => 'API',
                    "text" => "Simple notification message.",
                    "channel" => "#channel"
                )
            )
        )->shouldBeCalled();

        $this->send($message);

        // Send message with an added icon image
        $message->icon('http://img.com');

        $client->post("https://hooks.slack.com/services/token",
            array(
                "json" => array(
                    "username" => 'API',
                    "text" => "Simple notification message.",
                    "icon_url" => "http://img.com",
                    "channel" => "#channel"
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

    function it_gets_and_sets_the_channel()
    {
        // Get the current channel
        $this->getChannel()->shouldReturn('#channel');

        // Set the channel
        $this->setChannel('#channel');

        // Get the current channel
        $this->getChannel()->shouldReturn('#channel');
    }

    function it_gets_and_sets_the_icon()
    {
        // Get the current icon url
        $this->getIcon()->shouldReturn(null);

        // Set the icon url
        $this->setIcon('iconurl');

        // Get the current icon url
        $this->getIcon()->shouldReturn('iconurl');
    }
}

class SlackServiceStub extends SlackService {

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