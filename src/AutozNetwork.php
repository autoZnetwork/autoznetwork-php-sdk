<?php

namespace AutozNetwork;

use AutozNetwork\Plugins\WithOrganizationID;
use AutozNetwork\Requests\BodyStyleCollection;
use AutozNetwork\Requests\FeedCollection;
use AutozNetwork\Requests\InventoryCollection;
use AutozNetwork\Requests\LocationCollection;
use AutozNetwork\Requests\NotificationCollection;
use AutozNetwork\Requests\OrganizationCollection;
use AutozNetwork\Requests\PermissionCollection;
use AutozNetwork\Requests\RoleCollection;
use AutozNetwork\Requests\SyndicationCollection;
use AutozNetwork\Requests\UserCollection;
use Sammyjo20\Saloon\Helpers\OAuth2\OAuthConfig;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Traits\Plugins\AlwaysThrowsOnErrors;

/**
 * @method OrganizationCollection organizations
 * @method LocationCollection locations
 * @method InventoryCollection inventory
 * @method SyndicationCollection syndications
 * @method FeedCollection feeds
 * @method RoleCollection roles
 * @method PermissionCollection permissions
 * @method UserCollection users
 * @method NotificationCollection notifications
 * @method BodyStyleCollection bodyStyles
 */
class AutozNetwork extends SaloonConnector
{
    use AcceptsJson;
    use WithOrganizationID;
    use AlwaysThrowsOnErrors;

    protected string $apiBaseUrl = 'https://autoznetwork.com/api';

    private string $clientId;

    private string $clientSecret;

    private string $redirectUrl;

    private array $scopes = ['*'];

    /**
     * The requests/services on the AutozNetwork.
     *
     * @var array
     */
    protected array $requests = [
        'organizations' => OrganizationCollection::class,
        'locations' => LocationCollection::class,
        'inventory' => InventoryCollection::class,
        'syndications' => SyndicationCollection::class,
        'feeds' => FeedCollection::class,
        'roles' => RoleCollection::class,
        'permissions' => PermissionCollection::class,
        'users' => UserCollection::class,
        'notifications' => NotificationCollection::class,
        'bodyStyles' => BodyStyleCollection::class,
    ];

    public function __construct($authenticator, string $apiUrl = null) {
        $this->authenticator = $authenticator;

        if (! is_null($apiUrl)) {
            $this->apiBaseUrl = $apiUrl;
        }
    }

    /**
     * Define the base URL of the API.
     *
     * @return string
     */
    public function defineBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    /**
     * Define any default config.
     *
     * @return array
     */
    public function defaultConfig(): array
    {
        return [];
    }

    /**
     * Define the default OAuth2 Config.
     *
     * @return OAuthConfig
     */
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
}
