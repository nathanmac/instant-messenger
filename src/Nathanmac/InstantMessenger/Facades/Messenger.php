<?php namespace Nathanmac\InstantMessenger\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Nathanmac\InstantMessenger\Messenger
 */
class Messenger extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return '\Nathanmac\InstantMessenger\Messenger'; }

}
