<?php namespace Nathanmac\InstantMessenger\Services;

use Nathanmac\InstantMessenger\Message;

interface MessengerService {

    /**
     * Send message to the external service
     *
     * @param Message $message
     * @return mixed
     */
    public function send(Message $message);

}