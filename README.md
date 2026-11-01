# autoZnetwork PHP SDK

A [Saloon](https://docs.saloon.dev) client for the autoZnetwork API: inventory, locations,
organizations, enterprises, users, vehicle reference data, careers, feeds and syndications, plus the
OAuth client for signing users in through autoZnetwork. Optional Laravel wiring included.

Public API documentation: [autoznetwork.com/docs](https://autoznetwork.com/docs).

## Installation

The package is private. Add the repository, then require it:

```json
{
    "repositories": [
        { "type": "vcs", "url": "git@github.com:autoznetwork/autoznetwork-php-sdk.git" }
    ]
}
```

```bash
composer require autoznetwork/autoznetwork-php-sdk:^1.0
```

Requires PHP 8.3+. In a Laravel application (11, 12 or 13) the service provider and the `AutozNetwork`
facade are discovered automatically.

Upgrading from 0.x: the namespace moved from `AutozNetwork\` to `Autoznetwork\AutozNetwork\`. The old
names keep working in 1.x (see `CHANGELOG.md` for the one exception and the other breaking changes).

## Usage

```php
use Autoznetwork\AutozNetwork\AutozNetwork;
use Saloon\Http\Auth\TokenAuthenticator;

$client = new AutozNetwork(new TokenAuthenticator($apiToken));          // production API
$client = new AutozNetwork(new TokenAuthenticator($apiToken), $apiUrl); // another install

$vehicles = $client->withOrganization($organizationId)->inventory()->all(['limit' => 25]);
```

### Tenant scoping

Most endpoints act on one organization or one enterprise (a dealership group), sent in the
`X-AutozNetwork-Organization-Id` or `X-AutozNetwork-Enterprise-Id` header. `withOrganization()`,
`withEnterprise()` and `withEntity()` return a **new** client scoped to that tenant and leave the one
they were called on unchanged, so a client injected from the container can be scoped per call without
leaking the id into other requests:

```php
$scoped = $client->withOrganization($organizationId); // $client is still unscoped
$group = $client->withEnterprise($enterpriseId);
$either = $client->withEntity(EntityType::ORGANIZATION, $id);
```

Entity-scoped requests sent from an unscoped client throw `Saloon\Exceptions\MissingAuthenticatorException`
before any HTTP happens. Organizations and enterprises can be listed and fetched unscoped.

### Query helpers

Every resource accepts `filter()`, `exclude()`, `with()` (includes) and `orderBy()` before the call.
A resource is created fresh by each `$client->inventory()` call, so the state never carries over.

```php
$client->withOrganization($id)->inventory()
    ->filter(['make' => 'Ford', 'body_style' => 'truck'])
    ->with(['location', 'images'])
    ->orderBy('price', 'desc')
    ->all(['limit' => 50]);
```

### Resources

| Resource | Methods | Endpoint |
|---|---|---|
| `inventory()` | `all($params)`, `search($params, $term)`, `facets($params)` | `GET /inventory`, `/inventory/search`, `/inventory/facets` |
| `inventory()` | `get($id, $params)`, `withoutCache()->get($id)`, `related($id, $limit)` | `GET /inventory/{id}`, `/inventory/{id}/related` |
| `inventory()` | `getByStock()`, `getByVin()`, `getByStockAndVin()`, `findByStockOrVin()` | `GET /inventory` with filters |
| `inventory()` | `create($data)`, `update($id, $data)`, `activate($id)`, `deactivate($id)`, `delete($id)`, `audit($vehicles)` | `POST`, `PUT`, `DELETE /inventory/{id}`, `POST /inventory/audit` |
| `locations()` | `all($params)`, `get($idOrSlug)`, `create($data)`, `delete($id)` | `/locations` |
| `organizations()` | `all()`, `get($id, $params)`, `updateBanners($banners)` | `/organizations`, `/organizations/algolia-banners` |
| `enterprises()` | `all()`, `get($id, $params)` | `/enterprises` |
| `users()` | `all($params)`, `get($id, $params)`, `getByEmail($email, $params)` | `/users`, `/users/email` |
| `categories()` | `all()`, `get($idOrSlug)` | `/vehicle/categories` |
| `vehicle()->bodyStyles()` | `all()` | `/vehicle/body-styles` |
| `vehicle()->filters()` | `all($only)` | `/vehicle/filters` |
| `careers()->posts()` | `all($params)` | `/careers/posts` |
| `feeds()`, `syndications()` | `all()` | `/feeds`, `/syndications` |

`findByStockOrVin()` returns one vehicle whatever its stock status (sold vehicles included), by stock
number first and VIN second; `InventoryResource::ANY_VEHICLE_FILTERS` holds the query parameters it uses.

Methods return the decoded JSON body (`mixed`).

### Signing users in (OAuth)

```php
use Autoznetwork\AutozNetwork\AutozNetworkAuth;

$auth = new AutozNetworkAuth($clientId, $clientSecret, $redirectUrl, $authUrl ?? null, ['*']);

return redirect($auth->getAuthorizationUrl());                     // step 1
$authenticator = $auth->getAccessToken($request->query('code'));  // step 2, store it on the user
$profile = $auth->getUser($authenticator)->json();

if ($authenticator->hasExpired()) {
    $authenticator = $auth->refreshAccessToken($authenticator);
}

$client = new AutozNetwork($authenticator);                        // call the API as that user
```

## Laravel

| Env | Config key | Purpose |
|---|---|---|
| `AUTOZNETWORK_API_URL` | `autoznetwork.api_url` | Defaults to `https://api.autoznetwork.com/v1` |
| `AUTOZNETWORK_API_TOKEN` | `autoznetwork.api_token` | The application's own API token |
| `AUTOZNETWORK_API_SECRET` | `autoznetwork.api_secret` | Webhook signing secret shared with the hub |
| `AUTOZNETWORK_AUTH_URL` | `autoznetwork.auth_url` | Defaults to `https://autoznetwork.com` |
| `AUTOZNETWORK_CLIENT_ID` / `_CLIENT_SECRET` / `_REDIRECT_URL` | `autoznetwork.client_*`, `redirect_url` | OAuth application |
| `AUTOZNETWORK_CONNECT_TIMEOUT` / `AUTOZNETWORK_TIMEOUT` | `autoznetwork.timeout.*` | Seconds, default 5 / 30 |

```bash
php artisan vendor:publish --tag=autoznetwork-config
```

Inject the client or use the facade. Both build a fresh client on every resolve, authenticated with
the application token:

```php
use Autoznetwork\AutozNetwork\AutozNetwork;

final class FindVehicle
{
    public function __construct(private AutozNetwork $autozNetwork) {}

    public function handle(int $organizationId, ?string $stock, ?string $vin): ?array
    {
        return $this->autozNetwork->withOrganization($organizationId)->inventory()->findByStockOrVin($stock, $vin);
    }
}
```

```php
use Autoznetwork\AutozNetwork\Laravel\Facades\AutozNetwork;

AutozNetwork::withOrganization($organizationId)->locations()->all();
```

### Calling the API as the signed-in user

Register an authenticator resolver once; it runs every time a client is built, so each request gets
the right token under Octane. Return the user's stored OAuth authenticator (refreshed if needed), or
fall back to the application token:

```php
use Autoznetwork\AutozNetwork\AutozNetworkAuth;
use Autoznetwork\AutozNetwork\Exceptions\AuthenticatorMissing;
use Autoznetwork\AutozNetwork\Laravel\AutozNetworkFactory;
use Saloon\Contracts\Authenticator;

public function boot(AutozNetworkFactory $factory, AutozNetworkAuth $auth): void
{
    $factory->resolveAuthenticatorUsing(function () use ($factory, $auth): Authenticator {
        $user = auth()->user();

        if ($user === null || $user->isGlobalAdmin()) {
            return $factory->adminAuthenticator();
        }

        $authenticator = $user->autoznetwork_auth ?? throw AuthenticatorMissing::noUserToken();

        if ($authenticator->hasExpired()) {
            $user->forceFill(['autoznetwork_auth' => $authenticator = $auth->refreshAccessToken($authenticator)])->save();
        }

        return $authenticator;
    });
}
```

`$factory->asAdmin()` always uses the application token; `$factory->withAuthenticator($x)` builds a
client for any authenticator. `AutozNetworkAuth` is bound in the container from the same config.

## Errors

Every non-2xx response throws a Saloon exception from `Saloon\Exceptions\Request\Statuses`
(`UnauthorizedException`, `ForbiddenException`, `NotFoundException`, `UnprocessableEntityException`,
`TooManyRequestsException`, `ServiceUnavailableException`, ...), all extending
`Saloon\Exceptions\Request\RequestException`. Network failures throw
`Saloon\Exceptions\Request\FatalRequestException`. The response is on `$exception->getResponse()`.

When the body is not JSON (a maintenance page, a WAF block), the message is a one-line summary with the
status, content type, size and page title instead of the whole document.

## Testing

Use Saloon's `MockClient`; no HTTP leaves the process:

```php
use Autoznetwork\AutozNetwork\Requests\Inventory\ListInventoryRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

$mock = new MockClient([
    ListInventoryRequest::class => MockResponse::make(['data' => [['id' => 1]]]),
]);

$client->withMockClient($mock)->withOrganization(7)->inventory()->all();

$mock->assertSent(ListInventoryRequest::class);
```

In a Laravel test, `MockClient::global([...])` intercepts clients resolved from the container.

```bash
composer test
composer lint
```

## Versioning

Tagged with semantic versions. Require `^1.0`; breaking changes bump the major and are listed in
`CHANGELOG.md`.
