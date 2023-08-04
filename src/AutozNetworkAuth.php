<?php

namespace AutozNetwork;

use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;

class AutozNetworkAuth extends Connector
{
    use AuthorizationCodeGrant;

    protected string $apiBaseUrl = 'https://autoznetwork.com';

    private string $clientId;

    private string $clientSecret;

    private string $redirectUrl;

    private array $scopes = ['*'];

    public function resolveBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $redirectUrl,
        string $authUrl = null,
    ) {
        $this->clientId = $clientId;

        $this->clientSecret = $clientSecret;

        $this->redirectUrl = $redirectUrl;

        if (! is_null($authUrl)) {
            $this->apiBaseUrl = $authUrl;
        }
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
