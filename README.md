Instant Messenger
=================

[![License](http://img.shields.io/packagist/l/nathanmac/instant-messenger.svg)](https://github.com/nathanmac/instant-messenger/blob/master/LICENSE.md)
[![Build Status](https://travis-ci.org/nathanmac/instant-messenger.svg?branch=master)](https://travis-ci.org/nathanmac/instant-messenger)

Services Supported
------------------
- [x] HipChat
- [x] Slack
- [x] Hall
- [x] Jaconda
- [x] Sqwiggle
- [ ] FlowDock
- [ ] Campfire
- [ ] Gitter
- [ ] Grove
- [ ] IRC

Installation
------------

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `nathanmac/instant-messenger`.

	"require": {
		"nathanmac/instant-messenger": "1.*"
	}

Next, update Composer from the Terminal:

    composer update

### Laravel Users

If you are a Laravel user, then there is a service provider that you can make use of to automatically prepare the bindings and such.

```php
// app/config/app.php

'providers' => [
    '...',
    'Nathanmac\InstantMessenger\MessengerServiceProvider'
];
```

#### Configuration
After installing, you can publish the package configuration file into your application by running the following command:

    php artisan vendor:publish nathanmac/instant-messenger

#### Console Command
After installing and adding the service provider to the configuration file, you now have access to the `messenger:send`
command which allows you to send a simple notification from the command line, the following demonstrates the sending
of a simple message.

```
$ php artisan messenger:send "This is a test message to be sent using the configured service." --from "Auto Notifier"
```

### Example
```php
<?php

require 'vendor/autoload.php';

use Nathanmac\InstantMessenger\Messenger;
use Nathanmac\InstantMessenger\Services\HipChatService;
use Nathanmac\InstantMessenger\Services\SlackService;
use Nathanmac\InstantMessenger\Services\HallService;
use Nathanmac\InstantMessenger\Services\JacondaService;
use Nathanmac\InstantMessenger\Services\SqwiggleService;

// Hipchat
$transport = new HipChatService('HIPCHAT API TOKEN', 123456);

$messenger = new Messenger($transport);
$messenger->send(function($message) {
    $message->body('Hello this is a simple notification.');
});

// Sqwiggle
$transport = new SqwiggleService('SWIGGLE_TOKEN', 12345);

$messenger = new Messenger($transport);
$messenger->send(function($message) {
    $message->body('Hello this is a simple notification.');
});

// Slack
$transport = new SlackService('WEBHOOK TOKEN', '#channel');

$messenger = new Messenger($transport);
$messenger->send(function($message) {
    $message->body('Hello this is a simple notification.');
    $message->from('John Smith', 'john.smith@example.com');
});

// Hall
$transport = new HallService('API TOKEN');

$messenger = new Messenger($transport);
$messenger->send(function($message) {
    $message->body('Hello this is a simple notification.');
    $message->from('John Smith');
});

// Jaconda
$transport = new JacondaService('account', 'ROOM TOKEN', 'room');

$messenger = new Messenger($transport);
$messenger->send(function($message) {
  $message->body('Hello this is a simple notification.');
  $message->from('John Smith');
});
```