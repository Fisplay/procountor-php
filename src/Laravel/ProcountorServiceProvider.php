<?php

namespace Procountor\Laravel;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Procountor\Laravel\Commands\Authorize as CommandsAuthorize;
use Procountor\Procountor\Client;
use Procountor\Procountor\Environment;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Log\LoggerInterface;

class ProcountorServiceProvider extends ServiceProvider implements DeferrableProvider
{

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Client::class];
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/procountor.php' => config_path('procountor.php'),
            ], 'config');
            $this->commands([
                CommandsAuthorize::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/procountor.php', 'procountor');
        $this->app->bind(Client::class, fn ($app) => new Client(
            $app->make(ClientInterface::class),
            $app->make(RequestFactoryInterface::class),
            $app->make(StreamFactoryInterface::class),
            $app->make(LoggerInterface::class),
            $app->make(Environment::class),
            $app->make(CacheItemPoolInterface::class)
        ));
    }
}
