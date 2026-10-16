<?php

use AutozNetwork\AuthenticationType;
use AutozNetwork\AutozNetwork;
use AutozNetwork\Enums\EntityType;
use AutozNetwork\Requests\Organizations\GetOrganizationRequest;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

// guzzlehttp/psr7 3 rejects non-string header values, so the IDs are sent as strings.
function sentHeaders(AutozNetwork $connector): array
{
    $mockClient = new MockClient([MockResponse::make(['data' => []])]);

    $connector->withMockClient($mockClient)->send(new GetOrganizationRequest(1));

    return $mockClient->getLastPendingRequest()->headers()->all();
}

it('sends the organization id as a string', function () {
    $connector = (new AutozNetwork(new TokenAuthenticator('token')))->organization(42);

    expect(sentHeaders($connector)['X-AutozNetwork-Organization-Id'])->toBe('42');
});

it('sends the enterprise id as a string', function () {
    $connector = (new AutozNetwork(new TokenAuthenticator('token')))->enterprise(7);

    expect(sentHeaders($connector)['X-AutozNetwork-Enterprise-Id'])->toBe('7');
});

it('sends the entity id as a string', function () {
    $connector = new AutozNetwork(
        new TokenAuthenticator('token'),
        authenticationType: new AuthenticationType(EntityType::ORGANIZATION, 42),
    );

    expect(sentHeaders($connector)['X-AutozNetwork-organization-Id'])->toBe('42');
});
