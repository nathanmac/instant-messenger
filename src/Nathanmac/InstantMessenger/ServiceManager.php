<?php namespace Nathanmac\InstantMessenger;

use Illuminate\Support\Manager;
use Nathanmac\InstantMessenger\Services\CampFireService;
use Nathanmac\InstantMessenger\Services\FlowDockService;
use Nathanmac\InstantMessenger\Services\GitterService;
use Nathanmac\InstantMessenger\Services\GroveService;
use Nathanmac\InstantMessenger\Services\HallService;
use Nathanmac\InstantMessenger\Services\HipChatService;
use Nathanmac\InstantMessenger\Services\JacondaService;
use Nathanmac\InstantMessenger\Services\LogService;
use Nathanmac\InstantMessenger\Services\SlackService;
use Nathanmac\InstantMessenger\Services\SqwiggleService;

class ServiceManager extends Manager {

    /**
     * Initialise the HipChat service, with the configuration settings.
     *
     * @return HipChatService
     */
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

    /**
     * Initialise the Slack service, with the configuration settings.
     *
     * @return SlackService
     */
    public function createSlackDriver()
    {
        $config = $this->app['config']['messenger.connections.slack'];
        return SlackService::newInstance($config['token'], $config['channel'], isset($config['icon']) ? $config['icon'] : null);
    }

    /**
     * Initialise the Hall service, with the configuration settings.
     *
     * @return HallService
     */
    public function createHallDriver()
    {
        $config = $this->app['config']['messenger.connections.hall'];
        return HallService::newInstance($config['token'], isset($config['icon']) ? $config['icon'] : null);
    }

    /**
     * Initialise the Jaconda service, with the configuration settings.
     *
     * @return JacondaService
     */
    public function createJacondaDriver()
    {
        $config = $this->app['config']['messenger.connections.jaconda'];
        return JacondaService::newInstance($config['account'], $config['token'], $config['room']);
    }

    /**
     * Initialise the Sqwiggle service, with the configuration settings.
     *
     * @return SqwiggleService
     */
    public function createSqwiggleDriver()
    {
        $config = $this->app['config']['messenger.connections.sqwiggle'];
        return SqwiggleService::newInstance($config['token'], $config['stream']);
    }

    /**
     * Initialise the Gitter service, with the configuration settings.
     *
     * @return GitterService
     */
    public function createGitterDriver()
    {
        $config = $this->app['config']['messenger.connections.gitter'];
        return GitterService::newInstance($config['token']);
    }

    /**
     * Initialise the FlowDock service, with the configuration settings.
     *
     * @return FlowDockService
     */
    public function createFlowdockDriver()
    {
        $config = $this->app['config']['messenger.connections.flowdock'];
        return FlowDockService::newInstance($config['token'], isset($config['tags']) && is_array($config['tags']) ? $config['tags'] : array());
    }

    /**
     * Initialise the CampFire service, with the configuration settings.
     *
     * @return CampFireService
     */
    public function createCampfireDriver()
    {
        $config = $this->app['config']['messenger.connections.campfire'];
        return CampFireService::newInstance($config['subdomain'], $config['token'], $config['room']);
    }

    /**
     * Initialise the Grove service, with the configuration settings.
     *
     * @return GroveService
     */
    public function createGroveDriver()
    {
        $config = $this->app['config']['messenger.connections.grove'];
        return GroveService::newInstance($config['token'], isset($config['icon']) ? $config['icon'] : null);
    }

    /**
     * Initialise the Log service, with the configuration settings.
     *
     * @return LogService
     */
    public function createLogDriver()
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
     *
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']['messenger.driver'] = $name;
    }
}