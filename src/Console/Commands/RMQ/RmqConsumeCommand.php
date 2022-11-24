<?php

namespace Flagstudio\RmqFlag\Console\Commands\RMQ;

use Flagstudio\RmqFlag\Services\RMQ\RmqService;
use Illuminate\Console\Command;

class RmqConsumeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rmq:consume {queue?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consume messages from RMQ';

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
        /** @var RmqService $rmq */
        $rmq = app(RmqService::class);

        $rmq->listen($this->argument('queue') ?? config('rmq-flag.queue'));
    }
}
