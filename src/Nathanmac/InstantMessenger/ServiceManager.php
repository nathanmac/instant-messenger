<?php namespace Nathanmac\InstantMessenger;

use Illuminate\Support\Manager;
use Nathanmac\InstantMessenger\Services\FlowDockService;
use Nathanmac\InstantMessenger\Services\GitterService;
use Nathanmac\InstantMessenger\Services\HallService;
use Nathanmac\InstantMessenger\Services\HipChatService;
use Nathanmac\InstantMessenger\Services\JacondaService;
use Nathanmac\InstantMessenger\Services\LogService;
use Nathanmac\InstantMessenger\Services\SlackService;
use Nathanmac\InstantMessenger\Services\SqwiggleService;

class ServiceManager extends Manager {

    public function createHipchatDriver()
    {
        $config = $this->app['config']['messenger.connections.hipchat'];
        $service = HipChatService::newInstance($config['token'], $config['room'], $config['notify']);

        if (isset($config['color']))
        {
            $service->setColor($config['color']);
        }

        return $service;
    }

    public function createSlackDriver()
    {
        $config = $this->app['config']['messenger.connections.slack'];
        return SlackService::newInstance($config['token'], $config['channel']);
    }

    public function createHallDriver()
    {
        $config = $this->app['config']['messenger.connections.hall'];
        return HallService::newInstance($config['token']);
    }

    public function createJacondaDriver()
    {
        $config = $this->app['config']['messenger.connections.jaconda'];
        return JacondaService::newInstance($config['account'], $config['token'], $config['room']);
    }

    public function createSqwiggleDriver()
    {
        $config = $this->app['config']['messenger.connections.sqwiggle'];
        return SqwiggleService::newInstance($config['token'], $config['stream']);
    }

    public function createGitterDriver()
    {
        $config = $this->app['config']['messenger.connections.gitter'];
        return GitterService::newInstance($config['token']);
    }

    public function createFlowdockDriver()
    {
        $config = $this->app['config']['messenger.connections.gitter'];
        return FlowDockService::newInstance($config['token'], isset($config['tags']) && is_array($config['tags']) ? $config['tags'] : array());
    }

    protected function createLogDriver()
    {
        return LogService::newInstance($this->app->make('Psr\Log\LoggerInterface'));
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