<?php

use Autoznetwork\AutozNetwork\Requests\Careers\Posts\ListCareerPostsRequest;
use Autoznetwork\AutozNetwork\Requests\Enterprises\GetEnterpriseRequest;
use Autoznetwork\AutozNetwork\Requests\Enterprises\ListEnterprisesRequest;
use Autoznetwork\AutozNetwork\Requests\Feeds\ListFeedsRequest;
use Autoznetwork\AutozNetwork\Requests\Syndications\ListSyndicationsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('lists and gets enterprises without a tenant header', function () {
    $mock = new MockClient([
        ListEnterprisesRequest::class => MockResponse::make(['data' => [['id' => 2]]]),
        GetEnterpriseRequest::class => MockResponse::make(['id' => 2, 'organizations' => []]),
    ]);

    $enterprises = fakeAutozNetwork($mock)->enterprises();

    expect($enterprises->all()['data'][0]['id'])->toBe(2);

    $enterprises->get(2, ['include' => 'organizations']);

    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/enterprises/2')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['include' => 'organizations'])
        ->and($mock->getLastPendingRequest()->headers()->get('X-AutozNetwork-Enterprise-Id'))->toBeNull();
});

it('lists career posts that are active and listed, merging caller filters', function () {
    $mock = new MockClient([ListCareerPostsRequest::class => MockResponse::make(['data' => []])]);

    fakeAutozNetwork($mock, 7)->careers()->posts()->filter(['location_id' => 12])->all(['limit' => 20]);

    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/careers/posts')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe([
            'limit' => 20,
            'filter' => ['active' => true, 'listing.active' => true, 'location_id' => 12],
        ]);
});

it('lists feeds and syndications for the scoped organization', function () {
    $mock = new MockClient([
        ListFeedsRequest::class => MockResponse::make(['data' => []]),
        ListSyndicationsRequest::class => MockResponse::make(['data' => []]),
    ]);

    $client = fakeAutozNetwork($mock, 7);

    $client->feeds()->all();
    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/feeds');

    $client->syndications()->all();
    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/syndications')
        ->and($mock->getLastPendingRequest()->headers()->get('X-AutozNetwork-Organization-Id'))->toBe('7');
});
