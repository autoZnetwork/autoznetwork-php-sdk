<?php

namespace Autoznetwork\AutozNetwork\Tests;

use Autoznetwork\AutozNetwork\Laravel\AutozNetworkServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [AutozNetworkServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        /** @var Application $app */
        $app['config']->set('autoznetwork.api_url', 'https://api.autoznetwork.test/v1');
        $app['config']->set('autoznetwork.api_token', 'admin-token');
        $app['config']->set('autoznetwork.auth_url', 'https://autoznetwork.test');
        $app['config']->set('autoznetwork.client_id', 'client-id');
        $app['config']->set('autoznetwork.client_secret', 'client-secret');
        $app['config']->set('autoznetwork.redirect_url', 'https://app.test/autoznetwork/callback');
    }
}
