<?php namespace Nathanmac\InstantMessenger\Facades;

/**
 * @see \Nathanmac\InstantMessenger\Messenger
 */
class Messenger extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'messenger'; }

}
