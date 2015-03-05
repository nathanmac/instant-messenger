<?php
/**
 * Part of the Instant Messenger package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the MIT License.
 *
 */

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Service Driver
    |--------------------------------------------------------------------------
    |
    |
    */

    'driver' => 'hipchat',

    /*
     |--------------------------------------------------------------------------
     | Instant Messenger Services
     |--------------------------------------------------------------------------
     |
     |
     */

    'connections' => [

        'hipchat' => [
            'driver' => 'hipchat',
            'token'  => env('HIPCHAT_API_TOKEN', ''),
            'room'   => env('HIPCHAT_ROOM_ID', ''),
            'color'  => 'random',
            'notify' => true
        ],

        'slack' => [
            'driver'  => 'slack',
            'token'   => env('SLACK_TOKEN', ''),
            'channel' => env('SLACK_CHANNEL', '')
        ],

        'hall' => [
            'driver' => 'hall',
            'token'  => env('HALL_TOKEN', '')
        ],

        'jaconda' => [
            'driver'  => 'jaconda',
            'account' => env('JACONDA_ACCOUNT', ''),
            'token'   => env('JACONDA_TOKEN', ''),
            'room'    => env('JACONDA_ROOM', ''),
        ],

        'sqwiggle' => [
            'driver' => 'sqwiggle',
            'token'  => env('SQWIGGLE_TOKEN', ''),
            'stream' => env('SQWIGGLE_STREAM', '')
        ],

        'gitter' => [
            'driver' => 'gitter',
            'token'  => env('GITTER_TOKEN', '')
        ],

        'flowdock' => [
            'driver' => 'flowdock',
            'token'  => env('FLOW_API_TOKEN', ''),
            'tags'  => []
        ],

    ],

);