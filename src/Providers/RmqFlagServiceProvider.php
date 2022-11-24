<?php

namespace Flagstudio\RmqFlag\Providers;

use Flagstudio\RmqFlag\Console\Commands\RMQ\RmqConsumeCommand;
use Flagstudio\RmqFlag\Console\Commands\RMQ\RmqPublishCommand;
use Illuminate\Support\ServiceProvider;

class RmqFlagServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/rmq-flag.php', 'rmq-flag'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/rmq-flag.php' => config_path('rmq-flag.php'),
            ], 'config');

            if ($this->app->runningInConsole()) {
                $this->commands([
                    RmqConsumeCommand::class,
                    RmqPublishCommand::class,
                ]);
            }
        }
    }
}
