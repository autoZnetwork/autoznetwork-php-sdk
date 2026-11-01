<?php

namespace Autoznetwork\AutozNetwork;

use Saloon\Helpers\OAuth2\OAuthConfig;
use Saloon\Http\Connector;
use Saloon\Traits\OAuth2\AuthorizationCodeGrant;
use SensitiveParameter;

/**
 * OAuth2 authorization-code client for signing users in through autoZnetwork.
 *
 * `getAuthorizationUrl()`, `getAccessToken()`, `refreshAccessToken()` and
 * `getUser()` come from Saloon's AuthorizationCodeGrant. The access token it
 * returns is an Authenticator the API client accepts directly.
 */
class AutozNetworkAuth extends Connector
{
    use AuthorizationCodeGrant;

    public const string DEFAULT_AUTH_URL = 'https://autoznetwork.com';

    /**
     * @param  list<string>  $scopes
     */
    public function __construct(
        protected readonly string $clientId,
        #[SensitiveParameter] protected readonly string $clientSecret,
        protected readonly string $redirectUrl,
        protected readonly ?string $authUrl = null,
        protected readonly array $scopes = ['*'],
    ) {}

    public function resolveBaseUrl(): string
    {
        return rtrim($this->authUrl ?: self::DEFAULT_AUTH_URL, '/');
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
}
