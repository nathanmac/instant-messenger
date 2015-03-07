<?php namespace Nathanmac\InstantMessenger\Console;

use Illuminate\Console\Command;
use Nathanmac\InstantMessenger\Message;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MessengerCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'messenger:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a simple instant message notification using the messaging service.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->laravel['messenger']->send(function(Message $message) {
            // Body of the message
            $message->body($this->argument('text'));

            // From field for the message
            $message->from($this->option('from'), $this->option('email'));

            // Icon for the message
            $message->icon($this->option('image'));

            // Tags for the message (comma/pipe delimited)
            $message->tags(preg_split('/(,|\|) ?/', $this->option('tags')));
        });

        $this->info('Messenger: A message has been sent.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['text', InputArgument::REQUIRED, 'The text/body of the message to be sent.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['from', 'f', InputOption::VALUE_OPTIONAL, 'Set the name of the sender of the message.', null],
            ['tags', 't', InputOption::VALUE_OPTIONAL, 'Set the tags for the message being sent (comma delimited list).', null],
            ['email', 'e', InputOption::VALUE_OPTIONAL, 'Set the email of the sender of the message.', null],
            ['image', 'i', InputOption::VALUE_OPTIONAL, 'Set the image/icon of the message.', null]
        ];
    }

}
