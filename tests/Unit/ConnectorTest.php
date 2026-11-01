<?php

use Autoznetwork\AutozNetwork\AutozNetwork;
use Autoznetwork\AutozNetwork\Enums\EntityType;
use Autoznetwork\AutozNetwork\Requests\Inventory\ListInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Organizations\GetOrganizationRequest;
use GuzzleHttp\RequestOptions;
use Saloon\Exceptions\MissingAuthenticatorException;
use Saloon\Exceptions\Request\Statuses\ServiceUnavailableException;
use Saloon\Exceptions\Request\Statuses\UnprocessableEntityException;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

it('defaults to the production api and strips trailing slashes', function () {
    expect((new AutozNetwork(new TokenAuthenticator('t')))->resolveBaseUrl())->toBe('https://api.autoznetwork.com/v1')
        ->and((new AutozNetwork(new TokenAuthenticator('t'), 'https://api.autoznetwork.test/v1/'))->resolveBaseUrl())->toBe('https://api.autoznetwork.test/v1');
});

it('sends the token and asks for json', function () {
    $mock = new MockClient([GetOrganizationRequest::class => MockResponse::make(['id' => 1])]);

    fakeAutozNetwork($mock)->organizations()->get(1);

    $pending = $mock->getLastPendingRequest();

    expect($pending->headers()->get('Authorization'))->toBe('Bearer secret-token')
        ->and($pending->headers()->get('Accept'))->toBe('application/json')
        ->and($pending->headers()->get('X-AutozNetwork-Organization-Id'))->toBeNull()
        ->and($pending->headers()->get('X-AutozNetwork-Enterprise-Id'))->toBeNull();
});

it('applies the configured timeouts', function () {
    $mock = new MockClient([GetOrganizationRequest::class => MockResponse::make([])]);

    (new AutozNetwork(new TokenAuthenticator('t'), 'https://api.autoznetwork.test/v1', connectTimeout: 2, requestTimeout: 9))
        ->withMockClient($mock)
        ->organizations()
        ->get(1);

    $config = $mock->getLastPendingRequest()->config();

    expect($config->get(RequestOptions::CONNECT_TIMEOUT))->toEqual(2)
        ->and($config->get(RequestOptions::TIMEOUT))->toEqual(9);
});

describe('tenant scoping', function () {
    it('sends the organization id as a string header on a copy of the client', function () {
        $mock = new MockClient([ListInventoryRequest::class => MockResponse::make(['data' => []])]);

        $unscoped = fakeAutozNetwork($mock);
        $scoped = $unscoped->withOrganization(42);

        expect($scoped)->not->toBe($unscoped)
            ->and($scoped->organizationId())->toBe('42')
            ->and($unscoped->organizationId())->toBeNull();

        $scoped->inventory()->all();

        expect($mock->getLastPendingRequest()->headers()->get('X-AutozNetwork-Organization-Id'))->toBe('42');
    });

    it('sends the enterprise id as a string header', function () {
        $mock = new MockClient([ListInventoryRequest::class => MockResponse::make(['data' => []])]);

        fakeAutozNetwork($mock)->withEnterprise(7)->inventory()->all();

        $headers = $mock->getLastPendingRequest()->headers();

        expect($headers->get('X-AutozNetwork-Enterprise-Id'))->toBe('7')
            ->and($headers->get('X-AutozNetwork-Organization-Id'))->toBeNull();
    });

    it('scopes by entity type', function () {
        $mock = new MockClient([ListInventoryRequest::class => MockResponse::make(['data' => []])]);

        fakeAutozNetwork($mock)->withEntity(EntityType::ENTERPRISE, 9)->inventory()->all();
        expect($mock->getLastPendingRequest()->headers()->get('X-AutozNetwork-Enterprise-Id'))->toBe('9');

        fakeAutozNetwork($mock)->withEntity(EntityType::ORGANIZATION, 3)->inventory()->all();
        expect($mock->getLastPendingRequest()->headers()->get('X-AutozNetwork-Organization-Id'))->toBe('3');
    });

    it('refuses entity-scoped requests from an unscoped client', function () {
        $mock = new MockClient([ListInventoryRequest::class => MockResponse::make(['data' => []])]);

        fakeAutozNetwork($mock)->inventory()->all();
    })->throws(MissingAuthenticatorException::class, 'withOrganization()');

    it('allows unscoped requests that do not need an entity', function () {
        $mock = new MockClient([GetOrganizationRequest::class => MockResponse::make(['id' => 1])]);

        expect(fakeAutozNetwork($mock)->organizations()->get(1))->toBe(['id' => 1]);
    });

    it('does not share header stores between the copy and the original', function () {
        $original = new AutozNetwork(new TokenAuthenticator('t'));
        $original->headers()->add('X-Trace', 'original');

        $copy = $original->withOrganization(1);
        $copy->headers()->add('X-Trace', 'copy');

        expect($original->headers()->get('X-Trace'))->toBe('original')
            ->and($copy->headers()->get('X-Trace'))->toBe('copy');
    });
});

describe('errors', function () {
    it('throws saloon status exceptions for json errors', function () {
        $mock = new MockClient([
            GetOrganizationRequest::class => MockResponse::make(['message' => 'The include field is invalid.'], 422),
        ]);

        fakeAutozNetwork($mock)->organizations()->get(1);
    })->throws(UnprocessableEntityException::class, 'The include field is invalid.');

    it('summarizes html error pages instead of quoting them', function () {
        $page = '<html><head><title>Down for maintenance</title></head><body>'.str_repeat('x', 5000).'</body></html>';

        $mock = new MockClient([
            GetOrganizationRequest::class => MockResponse::make($page, 503, ['Content-Type' => 'text/html; charset=utf-8']),
        ]);

        try {
            fakeAutozNetwork($mock)->organizations()->get(1);
            $this->fail('Expected a ServiceUnavailableException.');
        } catch (ServiceUnavailableException $exception) {
            expect($exception->getMessage())
                ->toContain('autoZnetwork returned a non-JSON 503 response')
                ->toContain('"Down for maintenance"')
                ->not->toContain('xxxxx');
        }
    });
});
