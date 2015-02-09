<?php

namespace spec\Nathanmac\InstantMessenger\Services;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JacondaServiceSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('subdomain', 'token', 'room');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Nathanmac\InstantMessenger\Services\JacondaService');
    }

    function it_gets_and_sets_the_sub_domain()
    {
        // Get the current key
        $this->getSubDomain()->shouldReturn('subdomain');

        // Set the api key
        $this->setSubDomain('newsubdomain');

        // Get the current key
        $this->getSubDomain()->shouldReturn('newsubdomain');
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

    function it_gets_and_sets_the_room()
    {
        // Get the current key
        $this->getRoom()->shouldReturn('room');

        // Set the api key
        $this->setRoom('newroom');

        // Get the current key
        $this->getRoom()->shouldReturn('newroom');
    }
}
