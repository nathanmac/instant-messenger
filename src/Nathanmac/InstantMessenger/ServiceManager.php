<?php namespace Nathanmac\InstantMessenger;

use Illuminate\Support\Manager;
use Nathanmac\InstantMessenger\Services\HallService;
use Nathanmac\InstantMessenger\Services\HipChatService;
use Nathanmac\InstantMessenger\Services\JacondaService;
use Nathanmac\InstantMessenger\Services\SlackService;

class ServiceManager extends Manager {

    public function createHipchatDriver()
    {
        $config = $this->app['config']['messenger.connections']['hipchat'];
        $service = HipChatService::newInstance($config['token'], $config['room'], $config['notify']);

        if (isset($config['color']))
        {
            $service->setColor($config['color']);
        }

        return $service;
    }

    public function createSlackDriver()
    {
        $config = $this->app['config']['messenger.connections']['slack'];
        return new SlackService($config['token'], $config['channel']);
    }

    public function createHallDriver()
    {
        $config = $this->app['config']['messenger.connections']['hall'];
        return new HallService($config['token']);
    }

    public function createJacondaDriver()
    {
        $config = $this->app['config']['messenger.connections']['jaconda'];
        return new JacondaService($config['account'], $config['token'], $config['room']);
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