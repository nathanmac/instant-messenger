<?php namespace Nathanmac\InstantMessenger\Contracts;

interface Messenger {

    /**
     * Send a new instant message.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public function send($callback);

}
