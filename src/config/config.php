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
    | By default, the setup is for the HipChat service.
	|
	| Supported: "hipchat", "slack", "hall", "jaconda", "campfire",
    |               "sqwiggle", "gitter", "flowdock", "grove", "log"
    |
    */

    'driver' => env('MESSENGER_DRIVER', 'hipchat'),

    /*
     |--------------------------------------------------------------------------
     | Instant Messenger Services
     |--------------------------------------------------------------------------
	 |
     | Here you can configure the messenger "services".
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
            'channel' => env('SLACK_CHANNEL', ''),
            'icon'    => env('SLACK_ICON', null)
        ],

        'hall' => [
            'driver' => 'hall',
            'token'  => env('HALL_TOKEN', ''),
            'icon'   => env('HALL_ICON', null)
        ],

        'jaconda' => [
            'driver'  => 'jaconda',
            'account' => env('JACONDA_ACCOUNT', ''),
            'token'   => env('JACONDA_TOKEN', ''),
            'room'    => env('JACONDA_ROOM', ''),
        ],

        'campfire' => [
            'driver'    => 'campfire',
            'subdomain' => env('CAMPFIRE_SUBDOMAIN', ''),
            'token'     => env('CAMPFIRE_API_TOKEN', ''),
            'room'      => env('CAMPFIRE_ROOM', ''),
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

        'grove' => [
            'driver' => 'grove',
            'token'  => env('GROVE_API_TOKEN', ''),
            'icon'   => env('GROVE_ICON', null)
        ],

        'telegram' => [
            'driver'  => 'telegram',
            'token'   => env('TELEGRAM_TOKEN'),
            'chat_id' => env('TELEGRAM_CHAT_ID')
        ],

        'twilio' => [
            'driver'      => 'twilio',
            'account_sid' => env('TWILIO_ACCOUNT_SID', ''),
            'auth_token'  => env('TWILIO_AUTH_TOKEN', ''),
            'from'        => env('TWILIO_FROM', ''),
            'to'          => env('TWILIO_TO', null)
        ]
    ],

);