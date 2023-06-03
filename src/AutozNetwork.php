<?php

namespace AutozNetwork;

use AutozNetwork\Plugins\WithOrganizationID;
use AutozNetwork\Resources\BodyStyleResource;
use AutozNetwork\Resources\FeedResource;
use AutozNetwork\Resources\InventoryResource;
use AutozNetwork\Resources\LocationResource;
use AutozNetwork\Resources\NotificationResource;
use AutozNetwork\Resources\OrganizationResource;
use AutozNetwork\Resources\PermissionResource;
use AutozNetwork\Resources\RoleResource;
use AutozNetwork\Resources\SyndicationResource;
use AutozNetwork\Resources\UserResource;
use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class AutozNetwork extends Connector
{
    use AcceptsJson;
    use WithOrganizationID;
    use AlwaysThrowOnErrors;

    protected string $apiBaseUrl = 'https://autoznetwork.com/api';

    protected string $clientId;

    protected string $clientSecret;

    protected string $redirectUrl;

    protected array $scopes = ['*'];

    public function __construct($authenticator, string $apiUrl = null)
    {
        $this->authenticator = $authenticator;

        if (! is_null($apiUrl)) {
            $this->apiBaseUrl = $apiUrl;
        }
    }

    public function resolveBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make()
            ->setClientId($this->clientId)
            ->setClientSecret($this->clientSecret)
            ->setRedirectUri($this->redirectUrl)
            ->setDefaultScopes($this->scopes)
            ->setAuthorizeEndpoint('/oauth/authorize')
            ->setTokenEndpoint('/oauth/token')
            ->setUserEndpoint('/api/user');
    }

    public function bodyStyles(): BodyStyleResource
    {
        return new BodyStyleResource($this);
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

    public function notifications(): NotificationResource
    {
        return new NotificationResource($this);
    }

    public function organizations(): OrganizationResource
    {
        return new OrganizationResource($this);
    }

    public function permissions(): PermissionResource
    {
        return new PermissionResource($this);
    }

    public function roles(): RoleResource
    {
        return new RoleResource($this);
    }

    public function syndications(): SyndicationResource
    {
        return new SyndicationResource($this);
    }

    public function users(): UserResource
    {
        return new UserResource($this);
    }
}
