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
            'notify' => true
        ],

        'slack' => [
            'driver'  => 'slack',
            'webhook' => env('SLACK_WEBHOOK', ''),
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

    ],

);