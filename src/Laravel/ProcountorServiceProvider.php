<?php

namespace Procountor\Laravel;

use Illuminate\Support\ServiceProvider;
use Procountor\Procountor\Client;

class ProcountorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/procountor.php' => config_path('procountor.php'),
            ], 'config');
            $this->commands([
                // TODO
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/procountor.php', 'procountor');
        $this->app->singleton(Client::class, fn () => new Client(
            // TODO ....
        ));
    }
}
