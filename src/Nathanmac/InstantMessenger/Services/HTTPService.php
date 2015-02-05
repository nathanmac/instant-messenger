<?php namespace Nathanmac\InstantMessenger\Services;

use GuzzleHttp\Client;

abstract class HTTPService {

    /**
     * Get a new HTTP client instance.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getHttpClient()
    {
        return new Client;
    }
}