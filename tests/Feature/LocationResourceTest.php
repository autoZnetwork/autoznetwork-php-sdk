<?php

use Autoznetwork\AutozNetwork\Requests\Locations\CreateLocationRequest;
use Autoznetwork\AutozNetwork\Requests\Locations\DeleteLocationRequest;
use Autoznetwork\AutozNetwork\Requests\Locations\GetLocationRequest;
use Autoznetwork\AutozNetwork\Requests\Locations\ListLocationsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('lists locations with filters', function () {
    $mock = new MockClient([ListLocationsRequest::class => MockResponse::make(['data' => [['id' => 12]]])]);

    fakeAutozNetwork($mock, 7)->locations()->filter(['active' => true])->all(['limit' => 50]);

    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/locations')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['limit' => 50, 'filter' => ['active' => true]]);
});

it('gets a location by id or by an id-prefixed slug', function () {
    $mock = new MockClient([GetLocationRequest::class => MockResponse::make(['id' => 12])]);

    fakeAutozNetwork($mock, 7)->locations()->get(12);
    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/locations/12');

    fakeAutozNetwork($mock, 7)->locations()->get('12-main-street');
    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/locations/12');
});

it('creates and deletes locations', function () {
    $mock = new MockClient([
        CreateLocationRequest::class => MockResponse::make(['id' => 13], 201),
        DeleteLocationRequest::class => MockResponse::make(['deleted' => true]),
    ]);

    $locations = fakeAutozNetwork($mock, 7)->locations();

    $locations->create(['name' => 'Main Street']);
    expect($mock->getLastPendingRequest()->body()->all())->toBe(['name' => 'Main Street']);

    $locations->delete(13);
    expect($mock->getLastPendingRequest()->getMethod()->value)->toBe('DELETE')
        ->and($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/locations/13');
});
