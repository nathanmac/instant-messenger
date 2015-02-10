Instant Messenger
=================

[![Build Status](https://travis-ci.org/nathanmac/instant-messenger.svg?branch=master)](https://travis-ci.org/nathanmac/instant-messenger)

### Services Supported
- [x] HipChat
- [x] Slack
- [ ] FlowDock
- [ ] Campfire
- [ ] Gitter
- [x] Hall
- [x] Jaconda
- [ ] Grove
- [ ] Sqwiggle
- [ ] IRC
    
### Example
```php
<?php

require 'vendor/autoload.php';

use Nathanmac\InstantMessenger\Messenger;
use Nathanmac\InstantMessenger\Services\HipChatService;
use Nathanmac\InstantMessenger\Services\SlackService;
use Nathanmac\InstantMessenger\Services\HallService;
use Nathanmac\InstantMessenger\Services\JacondaService;

// Hipchat
$transport = new HipChatService('HIPCHAT API TOKEN', 123456);

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