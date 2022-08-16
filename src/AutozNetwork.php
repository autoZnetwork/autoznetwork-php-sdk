<?php

namespace AutozNetwork;

use AutozNetwork\Plugins\WithOrganizationID;
use AutozNetwork\Requests\FeedCollection;
use AutozNetwork\Requests\InventoryCollection;
use AutozNetwork\Requests\LocationCollection;
use AutozNetwork\Requests\OrganizationCollection;
use AutozNetwork\Requests\PermissionCollection;
use AutozNetwork\Requests\RoleCollection;
use AutozNetwork\Requests\SyndicationCollection;
use AutozNetwork\Requests\UserCollection;
use AutozNetwork\Responses\AutozNetworkResponse;
use Sammyjo20\Saloon\Helpers\OAuth2\OAuthConfig;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;

class AutozNetwork extends SaloonConnector
{
    use AcceptsJson;
//    use WithOrganizationID;

    /**
     * Define the base URL for the API
     *
     * @var string
     */
    protected string $apiBaseUrl = 'https://api.autoznetwork.com';

    private string $clientId;

    private string $clientSecret;

    private string $redirectUrl;

    private array $scopes = ['*'];

    /**
     * Custom response that all requests will return.
     *
     * @var string|null
     */
//    protected ?string $response = AutozNetworkResponse::class;

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
    ];

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
     * @param  string|null  $baseUrl
     */
    public function __construct(
        $authenticator,
        string $apiUrl = null
    ) {
        $this->authenticator = $authenticator;

        if (! is_null($apiUrl)) {
            $this->apiBaseUrl = $apiUrl;
        }
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

//    public function scopes(array $scopes): static
//    {
//        $this->scopes = $scopes;
//
//        return $this;
//    }
//
//    public function setScopes(array $scopes): static
//    {
//        return $this->scopes($scopes);
//    }
}
