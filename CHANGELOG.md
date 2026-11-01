# Changelog

All notable changes to `autoznetwork/autoznetwork-php-sdk` are documented here.

## Unreleased (1.0.0)

### Breaking

- The namespace is now `Autoznetwork\AutozNetwork\` (was `AutozNetwork\`). The old names keep working
  in 1.x through lazily autoloaded aliases under `compat/`, so `use` statements, type hints,
  `extends BaseResource` and `assertSent(OldName::class)` need no change yet. One exception: Saloon's
  `MockClient` looks responses up by the request's real class name, so test maps keyed by old request
  names (`[AutozNetwork\Requests\...::class => MockResponse::make()]`) must switch to the new names.
  The aliases are removed in 2.0.
- Tenant scoping is immutable: `withOrganization()`, `withEnterprise()` and `withEntity()` return a
  new client and leave the original unchanged. Code that called them and ignored the return value must
  use the returned client. The mutable `organization()` / `enterprise()` aliases are gone.
- `AutozNetwork::__construct(Authenticator $authenticator, ?string $apiUrl = null, ...)` is typed; the
  third `AuthenticationType` argument and the `AuthenticationType` class are gone. Use
  `withEntity(EntityType $type, int|string $id)`.
- Removed requests and resources whose endpoints no longer exist on the API: Notifications, Roles,
  Permissions, Feeds create/get/delete, Syndications create/get/delete, `users()->delete()`,
  `vehicle()->bodyStyles()->get()`, `CreateInventoryImageRequest`. `AuthenticationException` and
  `AutozNetworkRequestException` (never thrown) are gone.
- Request constructor properties are `protected readonly`; `defaultQuery()` / `defaultBody()` are
  protected.

### Added

- Laravel wiring: `AutozNetworkServiceProvider` (auto-discovered), `AutozNetworkFactory`
  (`make()`, `asAdmin()`, `withAuthenticator()`, `resolveAuthenticatorUsing()`, `auth()`), the
  `AutozNetwork` facade and `config/autoznetwork.php` with the env names the applications already use.
  Applications can delete their own `AutozNetworkServiceProvider` and `AutoznetworkUtil`.
- `AuthenticatorMissing` thrown when a client is built without any token.
- `InventoryResource::findByStockOrVin()` and `InventoryResource::ANY_VEHICLE_FILTERS` (from the
  ChatMonster wrapper), `InventoryResource::activate()`.
- `filter()`, `exclude()`, `with()` and `orderBy()` on every resource.
- `EntityType::header()`.
- Connect (5s) and request (30s) timeouts, configurable.
- Non-JSON error responses (maintenance pages, WAF blocks) are summarized instead of quoted in
  exception messages.

### Fixed

- `withEntity()` sent a lowercase `X-AutozNetwork-organization-Id` header.
- `defaultOauthConfig()` on the API connector read properties that were never set.

## 0.4.0

- Last release under the `AutozNetwork\` namespace (Saloon 4).
