<?php

use Autoznetwork\AutozNetwork\AutozNetwork;
use Autoznetwork\AutozNetwork\AutozNetworkAuth;
use Autoznetwork\AutozNetwork\Enums\EntityType;
use Autoznetwork\AutozNetwork\Requests\Enterprises\GetEnterpriseRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\ListInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Organizations\GetOrganizationRequest;
use Autoznetwork\AutozNetwork\Resources\BaseResource;
use Autoznetwork\AutozNetwork\Resources\InventoryResource;
use Autoznetwork\AutozNetwork\Resources\LocationResource;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

/**
 * The 0.x namespace keeps working through lazily autoloaded class aliases, so
 * consumers can bump to 1.0 and rename imports on their own schedule.
 */
it('resolves the old connector name to the new class', function () {
    $client = new \AutozNetwork\AutozNetwork(new TokenAuthenticator('t'), 'https://api.autoznetwork.test/v1');

    expect($client)->toBeInstanceOf(AutozNetwork::class)
        ->and(\AutozNetwork\AutozNetwork::class)->toBe('AutozNetwork\AutozNetwork')
        ->and(get_class($client))->toBe(AutozNetwork::class);
});

it('resolves old request, resource, enum and auth names', function (string $old, string $new) {
    expect(class_exists($old) || enum_exists($old))->toBeTrue()
        ->and(is_a($old, $new, true))->toBeTrue();
})->with([
    ['AutozNetwork\AutozNetworkAuth', AutozNetworkAuth::class],
    ['AutozNetwork\Enums\EntityType', EntityType::class],
    ['AutozNetwork\Resources\BaseResource', BaseResource::class],
    ['AutozNetwork\Resources\InventoryResource', InventoryResource::class],
    ['AutozNetwork\Resources\LocationResource', LocationResource::class],
    ['AutozNetwork\Requests\Inventory\ListInventoryRequest', ListInventoryRequest::class],
    ['AutozNetwork\Requests\Organizations\GetOrganizationRequest', GetOrganizationRequest::class],
    ['AutozNetwork\Requests\Enterprises\GetEnterpriseRequest', GetEnterpriseRequest::class],
]);

it('lets application classes keep extending the old base resource', function () {
    $resource = new class(new AutozNetwork(new TokenAuthenticator('t'))) extends \AutozNetwork\Resources\BaseResource {};

    expect($resource)->toBeInstanceOf(BaseResource::class);
});

it('matches old request names in assertSent through instanceof', function () {
    $mock = new MockClient([ListInventoryRequest::class => MockResponse::make(['data' => []])]);

    fakeAutozNetwork($mock, 1)->inventory()->all();

    $mock->assertSent(\AutozNetwork\Requests\Inventory\ListInventoryRequest::class);
});
