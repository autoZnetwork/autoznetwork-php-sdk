<?php

namespace Autoznetwork\AutozNetwork\Laravel;

use Autoznetwork\AutozNetwork\AutozNetwork;
use Autoznetwork\AutozNetwork\AutozNetworkAuth;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class AutozNetworkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/autoznetwork.php', 'autoznetwork');

        $this->app->singleton(AutozNetworkFactory::class, function (Application $app): AutozNetworkFactory {
            return new AutozNetworkFactory($app->make(Repository::class));
        });

        // A new client per resolve: the factory decides the authenticator at
        // resolve time, and nothing per request may be cached across Octane requests.
        $this->app->bind(AutozNetwork::class, function (Application $app): AutozNetwork {
            return $app->make(AutozNetworkFactory::class)->make();
        });

        $this->app->bind(AutozNetworkAuth::class, function (Application $app): AutozNetworkAuth {
            return $app->make(AutozNetworkFactory::class)->auth();
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/autoznetwork.php' => $this->app->configPath('autoznetwork.php'),
            ], 'autoznetwork-config');
        }
    }
}
