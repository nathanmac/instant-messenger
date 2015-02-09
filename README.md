Instant Messenger
=================

[![Build Status](https://travis-ci.org/nathanmac/instant-messenger.svg?branch=master)](https://travis-ci.org/nathanmac/instant-messenger)

### Services Supported
- [x] HipChat
- [x] Slack
- [ ] FlowDock
- [ ] Campfire
- [ ] Gitter
- [ ] Hall
- [ ] Jaconda
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

// Hipchat
$transport = new HipChatService('HIPCHAT API TOKEN', 123456);

$messenger = new Messenger($transport);
$messenger->send(function($message) {
    $message->body('Hello this is a simple notification.');
});


// Slack
$transport = new SlackService('WEBHOOKTOKEN');

$messenger = new Messenger($transport);
$messenger->send(function($message) {
    $message->body('Hello this is a simple notification.');
    $message->from('John Smith', 'john.smith@example.com');
});
```