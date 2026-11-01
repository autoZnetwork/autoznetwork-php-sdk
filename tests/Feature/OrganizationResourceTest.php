<?php

use Autoznetwork\AutozNetwork\Requests\Organizations\GetOrganizationRequest;
use Autoznetwork\AutozNetwork\Requests\Organizations\ListOrganizationsRequest;
use Autoznetwork\AutozNetwork\Requests\Organizations\UpdateBannersRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('lists the organizations the token can see without a tenant header', function () {
    $mock = new MockClient([ListOrganizationsRequest::class => MockResponse::make(['data' => [['id' => 7]]])]);

    expect(fakeAutozNetwork($mock)->organizations()->all()['data'][0]['id'])->toBe(7)
        ->and($mock->getLastPendingRequest()->headers()->get('X-AutozNetwork-Organization-Id'))->toBeNull();
});

it('gets an organization with includes', function () {
    $mock = new MockClient([GetOrganizationRequest::class => MockResponse::make(['id' => 7, 'enterprise' => ['id' => 2]])]);

    $organization = fakeAutozNetwork($mock)->organizations()->with(['enterprise'])->get(7);

    expect($organization['enterprise']['id'])->toBe(2)
        ->and($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/organizations/7')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['include' => 'enterprise']);
});

it('replaces the search banners for the scoped organization', function () {
    $mock = new MockClient([UpdateBannersRequest::class => MockResponse::make(['ok' => true])]);

    $banners = [['title' => 'Spring sale', 'url' => 'https://cars.example.com/sale']];

    fakeAutozNetwork($mock, 7)->organizations()->updateBanners($banners);

    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/organizations/algolia-banners')
        ->and($mock->getLastPendingRequest()->body()->all())->toBe(['banners' => $banners])
        ->and($mock->getLastPendingRequest()->headers()->get('X-AutozNetwork-Organization-Id'))->toBe('7');
});
