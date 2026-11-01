<?php

namespace Autoznetwork\AutozNetwork;

use Autoznetwork\AutozNetwork\Concerns\ClonesRequestProperties;
use Autoznetwork\AutozNetwork\Concerns\SummarizesNonJsonErrors;
use Autoznetwork\AutozNetwork\Enums\EntityType;
use Autoznetwork\AutozNetwork\Plugins\WithEnterpriseId;
use Autoznetwork\AutozNetwork\Plugins\WithOrganizationId;
use Autoznetwork\AutozNetwork\Resources\CareerResource;
use Autoznetwork\AutozNetwork\Resources\CategoryResource;
use Autoznetwork\AutozNetwork\Resources\EnterpriseResource;
use Autoznetwork\AutozNetwork\Resources\FeedResource;
use Autoznetwork\AutozNetwork\Resources\InventoryResource;
use Autoznetwork\AutozNetwork\Resources\LocationResource;
use Autoznetwork\AutozNetwork\Resources\OrganizationResource;
use Autoznetwork\AutozNetwork\Resources\SyndicationResource;
use Autoznetwork\AutozNetwork\Resources\UserResource;
use Autoznetwork\AutozNetwork\Resources\VehicleResource;
use NoDiscard;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;

/**
 * Client for the autoZnetwork API.
 *
 * Authenticate with an API token (`TokenAuthenticator`) or a user's OAuth
 * access token from `AutozNetworkAuth`. Most endpoints act on one organization
 * or enterprise, sent in the `X-AutozNetwork-Organization-Id` or
 * `X-AutozNetwork-Enterprise-Id` header: `withOrganization()`,
 * `withEnterprise()` and `withEntity()` return a new, scoped client and leave
 * this one untouched, so a container-bound instance can be shared safely.
 * Every error status throws one of Saloon's status exceptions.
 */
class AutozNetwork extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;
    use ClonesRequestProperties;
    use HasTimeout;
    use SummarizesNonJsonErrors;
    use WithEnterpriseId;
    use WithOrganizationId;

    public const string DEFAULT_API_URL = 'https://api.autoznetwork.com/v1';

    protected int $connectTimeout = 5;

    protected int $requestTimeout = 30;

    /**
     * @param  Authenticator  $authenticator  An API token or a user's OAuth authenticator.
     * @param  string|null  $apiUrl  API origin including the version prefix; defaults to production.
     */
    public function __construct(
        Authenticator $authenticator,
        protected readonly ?string $apiUrl = null,
        ?int $connectTimeout = null,
        ?int $requestTimeout = null,
    ) {
        $this->authenticate($authenticator);

        $this->connectTimeout = $connectTimeout ?? $this->connectTimeout;
        $this->requestTimeout = $requestTimeout ?? $this->requestTimeout;
    }

    public function resolveBaseUrl(): string
    {
        return rtrim($this->apiUrl ?: self::DEFAULT_API_URL, '/');
    }

    protected function serviceName(): string
    {
        return 'autoZnetwork';
    }

    /**
     * A copy of this client scoped to an organization or an enterprise.
     */
    #[NoDiscard('withEntity() returns a new client; the one it was called on is unchanged')]
    public function withEntity(EntityType $type, int|string $id): static
    {
        return match ($type) {
            EntityType::ORGANIZATION => $this->withOrganization($id),
            EntityType::ENTERPRISE => $this->withEnterprise($id),
        };
    }

    public function careers(): CareerResource
    {
        return new CareerResource($this);
    }

    public function categories(): CategoryResource
    {
        return new CategoryResource($this);
    }

    public function enterprises(): EnterpriseResource
    {
        return new EnterpriseResource($this);
    }

    public function feeds(): FeedResource
    {
        return new FeedResource($this);
    }

    public function inventory(): InventoryResource
    {
        return new InventoryResource($this);
    }

    public function locations(): LocationResource
    {
        return new LocationResource($this);
    }

    public function organizations(): OrganizationResource
    {
        return new OrganizationResource($this);
    }

    public function syndications(): SyndicationResource
    {
        return new SyndicationResource($this);
    }

    public function users(): UserResource
    {
        return new UserResource($this);
    }

    public function vehicle(): VehicleResource
    {
        return new VehicleResource($this);
    }
}
