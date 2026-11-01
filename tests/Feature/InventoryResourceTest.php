<?php

use Autoznetwork\AutozNetwork\Requests\Inventory\AuditInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\CreateInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\DeleteInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\GetInventoryFacetsRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\GetInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\GetRelatedInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\ListInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\SearchInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\UpdateInventoryRequest;
use Autoznetwork\AutozNetwork\Resources\InventoryResource;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

const BASE = 'https://api.autoznetwork.test/v1';

it('lists inventory with filters, includes and sorting', function () {
    $mock = new MockClient([ListInventoryRequest::class => MockResponse::make(['data' => [['id' => 1]]])]);

    $result = fakeAutozNetwork($mock, 7)->inventory()
        ->filter(['make' => 'Ford'])
        ->with(['location', 'images'])
        ->orderBy('price', 'desc')
        ->all(['limit' => 10]);

    expect($result['data'][0]['id'])->toBe(1);

    $pending = $mock->getLastPendingRequest();

    expect($pending->getUrl())->toBe(BASE.'/inventory')
        ->and($pending->query()->all())->toBe([
            'limit' => 10,
            'filter' => ['make' => 'Ford'],
            'include' => 'location,images',
            'sort' => 'price',
            'sort_direction' => 'desc',
        ])
        ->and($pending->headers()->get('X-AutozNetwork-Organization-Id'))->toBe('7');
});

it('gets one vehicle, fresh when asked', function () {
    $mock = new MockClient([GetInventoryRequest::class => MockResponse::make(['id' => 42])]);

    fakeAutozNetwork($mock, 7)->inventory()->get(42, ['include' => 'location']);

    expect($mock->getLastPendingRequest()->getUrl())->toBe(BASE.'/inventory/42')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['include' => 'location']);

    fakeAutozNetwork($mock, 7)->inventory()->withoutCache()->get(42);

    expect($mock->getLastPendingRequest()->query()->all())->toBe(['no-cache' => false]);
});

it('finds a vehicle by vin whatever its stock status', function () {
    $mock = new MockClient([ListInventoryRequest::class => MockResponse::make(['data' => [['id' => 5, 'vin' => '1HGCM82633A004352']]])]);

    $vehicle = fakeAutozNetwork($mock, 7)->inventory()->getByVin('1HGCM82633A004352');

    expect($vehicle['id'])->toBe(5)
        ->and($mock->getLastPendingRequest()->query()->all())->toBe([
            'stock_status' => '1,0',
            'limit' => 1,
            'filter' => ['vin' => '1HGCM82633A004352'],
        ]);
});

it('returns null when nothing matches the stock number', function () {
    $mock = new MockClient([ListInventoryRequest::class => MockResponse::make(['data' => []])]);

    expect(fakeAutozNetwork($mock, 7)->inventory()->getByStock('A123', online: true))->toBeNull()
        ->and($mock->getLastPendingRequest()->query()->get('stock_status'))->toBe('1');
});

describe('findByStockOrVin', function () {
    it('returns the vehicle found by stock number, sold or not', function () {
        $mock = new MockClient([ListInventoryRequest::class => MockResponse::make(['data' => [['id' => 9, 'stock' => 'A123']]])]);

        $vehicle = fakeAutozNetwork($mock, 7)->inventory()->findByStockOrVin('A123', '1HGCM82633A004352', ['include' => 'images']);

        expect($vehicle['id'])->toBe(9);

        $mock->assertSentCount(1);

        expect($mock->getLastPendingRequest()->query()->all())->toBe([
            'include' => 'images',
            ...InventoryResource::ANY_VEHICLE_FILTERS,
            'limit' => 1,
            'filter[stock]' => 'A123',
        ]);
    });

    it('falls back to the vin when the stock number finds nothing', function () {
        $mock = new MockClient([
            MockResponse::make(['data' => []]),
            MockResponse::make(['data' => [['id' => 10]]]),
        ]);

        $vehicle = fakeAutozNetwork($mock, 7)->inventory()->findByStockOrVin('A123', '1HGCM82633A004352');

        expect($vehicle['id'])->toBe(10);

        $mock->assertSentCount(2);

        expect($mock->getLastPendingRequest()->query()->get('filter[vin]'))->toBe('1HGCM82633A004352');
    });

    it('skips blank identifiers and returns null when nothing is found', function () {
        $mock = new MockClient([ListInventoryRequest::class => MockResponse::make(['data' => []])]);

        expect(fakeAutozNetwork($mock, 7)->inventory()->findByStockOrVin('', '1HGCM82633A004352'))->toBeNull();

        $mock->assertSentCount(1);
    });
});

it('searches inventory with a term', function () {
    $mock = new MockClient([SearchInventoryRequest::class => MockResponse::make(['data' => []])]);

    fakeAutozNetwork($mock, 7)->inventory()->orderBy('year')->search(['limit' => 5], 'red truck');

    expect($mock->getLastPendingRequest()->getUrl())->toBe(BASE.'/inventory/search')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['limit' => 5, 'query' => 'red truck', 'sort' => 'year']);
});

it('gets related vehicles', function () {
    $mock = new MockClient([GetRelatedInventoryRequest::class => MockResponse::make(['data' => []])]);

    fakeAutozNetwork($mock, 7)->inventory()->related(42, 6);

    expect($mock->getLastPendingRequest()->getUrl())->toBe(BASE.'/inventory/42/related')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['limit' => 6]);
});

it('creates, updates and deletes vehicles', function () {
    $mock = new MockClient([
        CreateInventoryRequest::class => MockResponse::make(['id' => 1], 201),
        UpdateInventoryRequest::class => MockResponse::make(['id' => 1, 'active' => false]),
        DeleteInventoryRequest::class => MockResponse::make(['deleted' => true]),
    ]);

    $inventory = fakeAutozNetwork($mock, 7)->inventory();

    $inventory->create(['vin' => '1HGCM82633A004352', 'stock' => 'A123']);
    expect($mock->getLastPendingRequest()->getMethod()->value)->toBe('POST')
        ->and($mock->getLastPendingRequest()->body()->all())->toBe(['vin' => '1HGCM82633A004352', 'stock' => 'A123']);

    $inventory->deactivate(1);
    expect($mock->getLastPendingRequest()->getMethod()->value)->toBe('PUT')
        ->and($mock->getLastPendingRequest()->getUrl())->toBe(BASE.'/inventory/1')
        ->and($mock->getLastPendingRequest()->body()->all())->toBe(['active' => false]);

    $inventory->delete(1);
    expect($mock->getLastPendingRequest()->getMethod()->value)->toBe('DELETE');
});

it('audits a vehicle list and reads facets', function () {
    $mock = new MockClient([
        AuditInventoryRequest::class => MockResponse::make(['missing' => []]),
        GetInventoryFacetsRequest::class => MockResponse::make(['make' => ['Ford' => 3]]),
    ]);

    $inventory = fakeAutozNetwork($mock, 7)->inventory();

    $inventory->audit([['vin' => '1HGCM82633A004352']]);
    expect($mock->getLastPendingRequest()->getUrl())->toBe(BASE.'/inventory/audit')
        ->and($mock->getLastPendingRequest()->body()->all())->toBe(['vehicles' => [['vin' => '1HGCM82633A004352']]]);

    $inventory->facets(['filter' => ['body_style' => 'truck']]);
    expect($mock->getLastPendingRequest()->getUrl())->toBe(BASE.'/inventory/facets')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['filter' => ['body_style' => 'truck']]);
});
