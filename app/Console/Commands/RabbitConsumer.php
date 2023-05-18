<?php

namespace App\Console\Commands;

use App\Rabbitmq\Rabbit\Client;
use Illuminate\Console\Command;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitConsumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbit:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consumes RabbitMQ message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(Client $client)
    {
        $client->consume('agent-service', function (AMQPMessage $message) {
            /**
             * @var Client $this
             */
            $this->dispatchEvents($message);

            $message->ack();
        })->wait();
    }
}
