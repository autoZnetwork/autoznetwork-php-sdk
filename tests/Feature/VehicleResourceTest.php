<?php

use Autoznetwork\AutozNetwork\Requests\Categories\GetCategoryRequest;
use Autoznetwork\AutozNetwork\Requests\Categories\ListCategoriesRequest;
use Autoznetwork\AutozNetwork\Requests\Vehicle\BodyStyles\ListBodyStylesRequest;
use Autoznetwork\AutozNetwork\Requests\Vehicle\Filters\ListFiltersRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('lists and gets vehicle categories', function () {
    $mock = new MockClient([
        ListCategoriesRequest::class => MockResponse::make(['data' => [['id' => 1, 'slug' => 'truck']]]),
        GetCategoryRequest::class => MockResponse::make(['id' => 1, 'slug' => 'truck']),
    ]);

    $categories = fakeAutozNetwork($mock, 7)->categories();

    $categories->orderBy('name', 'asc')->all();
    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/vehicle/categories')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['sort' => 'name', 'sort_direction' => 'asc']);

    $categories->get('truck');
    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/vehicle/categories/truck');
});

it('lists body styles sorted', function () {
    $mock = new MockClient([ListBodyStylesRequest::class => MockResponse::make(['data' => []])]);

    fakeAutozNetwork($mock, 7)->vehicle()->bodyStyles()->orderBy('id')->all();

    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/vehicle/body-styles')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['sort' => 'id']);
});

it('lists filters, optionally only some groups', function () {
    $mock = new MockClient([ListFiltersRequest::class => MockResponse::make(['makes' => []])]);

    fakeAutozNetwork($mock, 7)->vehicle()->filters()->all();
    expect($mock->getLastPendingRequest()->query()->all())->toBe([]);

    fakeAutozNetwork($mock, 7)->vehicle()->filters()->all(['makes', 'body_styles']);
    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/vehicle/filters')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['only' => 'makes,body_styles']);
});
