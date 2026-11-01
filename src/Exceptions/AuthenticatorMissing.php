<?php

namespace Autoznetwork\AutozNetwork\Exceptions;

use RuntimeException;

/**
 * Thrown when a client is asked for but nothing can authenticate it.
 */
final class AuthenticatorMissing extends RuntimeException
{
    public static function noAdminToken(): self
    {
        return new self('No autoZnetwork API token is configured: set AUTOZNETWORK_API_TOKEN (config autoznetwork.api_token).');
    }

    public static function noUserToken(): self
    {
        return new self('The signed-in user has no autoZnetwork OAuth token; sign in through autoZnetwork first.');
    }
}
