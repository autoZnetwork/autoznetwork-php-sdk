<?php

use Autoznetwork\AutozNetwork\Requests\Users\GetUserByEmailRequest;
use Autoznetwork\AutozNetwork\Requests\Users\GetUserRequest;
use Autoznetwork\AutozNetwork\Requests\Users\ListUsersRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('lists users in the organization', function () {
    $mock = new MockClient([ListUsersRequest::class => MockResponse::make(['data' => []])]);

    fakeAutozNetwork($mock, 7)->users()->all(['limit' => 100]);

    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/users')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['limit' => 100]);
});

it('gets a user by id', function () {
    $mock = new MockClient([GetUserRequest::class => MockResponse::make(['id' => 5])]);

    fakeAutozNetwork($mock, 7)->users()->with(['roles'])->get(5);

    expect($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/users/5')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['include' => 'roles']);
});

it('gets a user by email', function () {
    $mock = new MockClient([GetUserByEmailRequest::class => MockResponse::make(['id' => 5, 'email' => 'pat@example.test'])]);

    $user = fakeAutozNetwork($mock, 7)->users()->getByEmail('pat@example.test');

    expect($user['id'])->toBe(5)
        ->and($mock->getLastPendingRequest()->getUrl())->toBe('https://api.autoznetwork.test/v1/users/email')
        ->and($mock->getLastPendingRequest()->query()->all())->toBe(['email' => 'pat@example.test']);
});
