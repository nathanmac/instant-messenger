<?php namespace Nathanmac\InstantMessenger\Contracts;

interface MessengerQueue {

    /**
     * Queue a new instance message for sending.
     *
     * @param  array   $data
     * @param  \Closure|string  $callback
     * @return mixed
     */
    public function queue(array $data, $callback);

    /**
     * Queue a new instance message for sending after (n) seconds.
     *
     * @param  int  $delay
     * @param  array  $data
     * @param  \Closure|string  $callback
     * @return mixed
     */
    public function later($delay, array $data, $callback);

}
