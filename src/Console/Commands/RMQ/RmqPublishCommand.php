<?php

namespace Flagstudio\RmqFlag\Console\Commands\RMQ;

use Flagstudio\RmqFlag\Services\RMQ\RmqService;
use Illuminate\Console\Command;

class RmqPublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rmq:publish {message?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish messages to RMQ';

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
    public function handle(): void
    {
        if (empty($this->argument('message'))) {
            return;
        }

        /** @var RMQService $rmq */
        $rmq = app(RmqService::class);

        $rmq->publish($this->argument('message'));
    }
}
