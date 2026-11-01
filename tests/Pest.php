<?php

use Autoznetwork\AutozNetwork\AutozNetwork;
use Autoznetwork\AutozNetwork\Tests\TestCase;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Faking\MockClient;

pest()->extend(TestCase::class)->in('Laravel');

/**
 * A client pointed at a fake API, with every request answered by the mock.
 */
function fakeAutozNetwork(MockClient $mock, int|string|null $organizationId = null, string $apiUrl = 'https://api.autoznetwork.test/v1'): AutozNetwork
{
    $client = (new AutozNetwork(new TokenAuthenticator('secret-token'), $apiUrl))->withMockClient($mock);

    return $organizationId === null ? $client : $client->withOrganization($organizationId);
}
