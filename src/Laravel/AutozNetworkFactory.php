<?php

namespace Autoznetwork\AutozNetwork\Laravel;

use Autoznetwork\AutozNetwork\AutozNetwork;
use Autoznetwork\AutozNetwork\AutozNetworkAuth;
use Autoznetwork\AutozNetwork\Exceptions\AuthenticatorMissing;
use Closure;
use Illuminate\Contracts\Config\Repository;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;

/**
 * Builds API and OAuth clients for the container.
 *
 * By default a client authenticates with the application's API token. An
 * application that acts on behalf of the signed-in user registers a resolver
 * that returns that user's OAuth authenticator (refreshing it first if it has
 * expired); the resolver runs on every resolve, so each request gets its own
 * client with the right token, which is what Octane needs.
 *
 * The factory is stateless apart from the resolver, so it is a singleton.
 */
final class AutozNetworkFactory
{
    /**
     * @var (Closure(): Authenticator)|null
     */
    private ?Closure $authenticatorResolver = null;

    public function __construct(
        private readonly Repository $config,
    ) {}

    /**
     * Decide at resolve time how the next client authenticates.
     *
     * The closure may read request state (the signed-in user) when it runs,
     * but it must not capture request state when it is registered, since the
     * factory outlives the request under Octane. Throw
     * `AuthenticatorMissing::noUserToken()` when the user has no token, or
     * return `adminAuthenticator()` to fall back to the application token.
     *
     * @param  (Closure(): Authenticator)|null  $resolver
     */
    public function resolveAuthenticatorUsing(?Closure $resolver): void
    {
        $this->authenticatorResolver = $resolver;
    }

    /**
     * A client authenticated by the resolver, or by the application token.
     */
    public function make(): AutozNetwork
    {
        return $this->withAuthenticator($this->authenticator());
    }

    /**
     * A client authenticated by the application token, whatever the resolver says.
     */
    public function asAdmin(): AutozNetwork
    {
        return $this->withAuthenticator($this->adminAuthenticator());
    }

    public function withAuthenticator(Authenticator $authenticator): AutozNetwork
    {
        return new AutozNetwork(
            authenticator: $authenticator,
            apiUrl: $this->config->get('autoznetwork.api_url'),
            connectTimeout: $this->config->get('autoznetwork.timeout.connect'),
            requestTimeout: $this->config->get('autoznetwork.timeout.request'),
        );
    }

    public function authenticator(): Authenticator
    {
        return $this->authenticatorResolver instanceof Closure
            ? ($this->authenticatorResolver)()
            : $this->adminAuthenticator();
    }

    /**
     * @throws AuthenticatorMissing when no API token is configured
     */
    public function adminAuthenticator(): TokenAuthenticator
    {
        $token = (string) $this->config->get('autoznetwork.api_token', '');

        if (trim($token) === '') {
            throw AuthenticatorMissing::noAdminToken();
        }

        return new TokenAuthenticator($token);
    }

    /**
     * Whether an application token is configured.
     */
    public function hasAdminToken(): bool
    {
        return trim((string) $this->config->get('autoznetwork.api_token', '')) !== '';
    }

    /**
     * The OAuth client for signing users in through autoZnetwork.
     */
    public function auth(): AutozNetworkAuth
    {
        return new AutozNetworkAuth(
            clientId: (string) $this->config->get('autoznetwork.client_id', ''),
            clientSecret: (string) $this->config->get('autoznetwork.client_secret', ''),
            redirectUrl: (string) $this->config->get('autoznetwork.redirect_url', ''),
            authUrl: $this->config->get('autoznetwork.auth_url'),
            scopes: (array) $this->config->get('autoznetwork.scopes', ['*']),
        );
    }
}
