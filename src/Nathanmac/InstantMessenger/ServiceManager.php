<?php namespace Nathanmac\InstantMessenger;

use Illuminate\Support\Manager;

class ServiceManager extends Manager {


    public function createHipchatDriver()
    {

    }

    public function createSlackDriver()
    {

    }

    public function createHallDriver()
    {

    }

    public function createJacondaDriver()
    {

    }

    /**
     * Get the default cache driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['messenger.driver'];
    }

    /**
     * Set the default cache driver name.
     *
     * @param  string  $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['messenger.driver'] = $name;
    }
}