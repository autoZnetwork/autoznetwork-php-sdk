<?php

namespace AutozNetwork;

use Sammyjo20\Saloon\Helpers\OAuth2\OAuthConfig;
use Sammyjo20\Saloon\Http\SaloonConnector;
use Sammyjo20\Saloon\Traits\OAuth2\AuthorizationCodeGrant;

class AutozNetworkAuth extends SaloonConnector
{
    use AuthorizationCodeGrant;

    /**
     * Define the base URL for the API
     *
     * @var string
     */
    protected string $apiBaseUrl = 'https://autoznetwork.com';

    private string $clientId;

    private string $clientSecret;

    private string $redirectUrl;

    private array $scopes = ['*'];

    public function defineBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $redirectUrl,
        string $authUrl = null
    ) {
        $this->clientId = $clientId;

        $this->clientSecret = $clientSecret;

        $this->redirectUrl = $redirectUrl;

        if (! is_null($authUrl)) {
            $this->apiBaseUrl = $authUrl;
        }
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
