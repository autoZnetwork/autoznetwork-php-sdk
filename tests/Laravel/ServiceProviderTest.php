<?php

use Autoznetwork\AutozNetwork\AutozNetwork;
use Autoznetwork\AutozNetwork\AutozNetworkAuth;
use Autoznetwork\AutozNetwork\Exceptions\AuthenticatorMissing;
use Autoznetwork\AutozNetwork\Laravel\AutozNetworkFactory;
use Autoznetwork\AutozNetwork\Laravel\Facades\AutozNetwork as AutozNetworkFacade;
use Autoznetwork\AutozNetwork\Requests\Organizations\GetOrganizationRequest;
use Saloon\Http\Auth\AccessTokenAuthenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('merges the package config with the application config', function () {
    expect(config('autoznetwork.api_url'))->toBe('https://api.autoznetwork.test/v1')
        ->and(config('autoznetwork.scopes'))->toBe(['*'])
        ->and(config('autoznetwork.timeout.connect'))->toBe(5);
});

it('builds a new client per resolve, authenticated with the application token', function () {
    MockClient::global([GetOrganizationRequest::class => MockResponse::make(['id' => 1])]);

    $first = app(AutozNetwork::class);
    $second = app(AutozNetwork::class);

    expect($first)->toBeInstanceOf(AutozNetwork::class)
        ->and($second)->not->toBe($first)
        ->and($first->resolveBaseUrl())->toBe('https://api.autoznetwork.test/v1');

    $first->organizations()->get(1);

    expect(MockClient::getGlobal()->getLastPendingRequest()->headers()->get('Authorization'))->toBe('Bearer admin-token');

    MockClient::destroyGlobal();
});

it('shares one factory', function () {
    expect(app(AutozNetworkFactory::class))->toBe(app(AutozNetworkFactory::class));
});

it('lets the application supply the signed-in user\'s authenticator per resolve', function () {
    MockClient::global([GetOrganizationRequest::class => MockResponse::make(['id' => 1])]);

    $calls = 0;

    app(AutozNetworkFactory::class)->resolveAuthenticatorUsing(function () use (&$calls): AccessTokenAuthenticator {
        $calls++;

        return new AccessTokenAuthenticator('user-token-'.$calls);
    });

    app(AutozNetwork::class)->organizations()->get(1);
    expect(MockClient::getGlobal()->getLastPendingRequest()->headers()->get('Authorization'))->toBe('Bearer user-token-1');

    app(AutozNetwork::class)->organizations()->get(1);
    expect(MockClient::getGlobal()->getLastPendingRequest()->headers()->get('Authorization'))->toBe('Bearer user-token-2');

    app(AutozNetworkFactory::class)->asAdmin()->organizations()->get(1);
    expect(MockClient::getGlobal()->getLastPendingRequest()->headers()->get('Authorization'))->toBe('Bearer admin-token');

    MockClient::destroyGlobal();
});

it('builds a client for an explicit authenticator', function () {
    MockClient::global([GetOrganizationRequest::class => MockResponse::make(['id' => 1])]);

    app(AutozNetworkFactory::class)->withAuthenticator(new TokenAuthenticator('other'))->organizations()->get(1);

    expect(MockClient::getGlobal()->getLastPendingRequest()->headers()->get('Authorization'))->toBe('Bearer other');

    MockClient::destroyGlobal();
});

it('fails loudly when no application token is configured', function () {
    config()->set('autoznetwork.api_token', '');

    expect(app(AutozNetworkFactory::class)->hasAdminToken())->toBeFalse();

    app(AutozNetwork::class);
})->throws(AuthenticatorMissing::class, 'AUTOZNETWORK_API_TOKEN');

it('binds the oauth client from config', function () {
    $auth = app(AutozNetworkAuth::class);

    expect($auth)->toBeInstanceOf(AutozNetworkAuth::class)
        ->and($auth->resolveBaseUrl())->toBe('https://autoznetwork.test')
        ->and($auth->getAuthorizationUrl())->toStartWith('https://autoznetwork.test/oauth/authorize?')
        ->toContain('client_id=client-id')
        ->toContain('redirect_uri='.urlencode('https://app.test/autoznetwork/callback'));
});

it('reads timeouts from config', function () {
    config()->set('autoznetwork.timeout.connect', 3);
    config()->set('autoznetwork.timeout.request', 12);

    $client = app(AutozNetwork::class);

    expect($client->getConnectTimeout())->toEqual(3)
        ->and($client->getRequestTimeout())->toEqual(12);
});

it('resolves a fresh client through the facade', function () {
    expect(AutozNetworkFacade::getFacadeRoot())->not->toBe(AutozNetworkFacade::getFacadeRoot())
        ->and(AutozNetworkFacade::withOrganization(5)->organizationId())->toBe('5');
});
