<?php namespace Nathanmac\InstantMessenger\Contracts;

interface MessengerQueue {

    /**
     * Queue a new instance message for sending.
     *
     * @param  \Closure|string  $callback
     * @param  string  $queue
     * @return mixed
     */
    public function queue($callback, $queue = null);

    /**
     * Queue a new instance message for sending after (n) seconds.
     *
     * @param  int  $delay
     * @param  \Closure|string  $callback
     * @param  string  $queue
     * @return mixed
     */
    public function later($delay, $callback, $queue = null);
}
