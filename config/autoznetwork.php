<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    |
    | The API origin including the version prefix, and the application's own
    | API token. The token authenticates server-to-server calls; a signed-in
    | user's OAuth token can be used instead by registering an authenticator
    | resolver on AutozNetworkFactory.
    |
    */

    'api_url' => env('AUTOZNETWORK_API_URL', 'https://api.autoznetwork.com/v1'),

    'api_token' => env('AUTOZNETWORK_API_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Webhook signing secret
    |--------------------------------------------------------------------------
    |
    | Shared with autoZnetwork; signs webhooks in both directions (see the
    | autoznetwork/webhook-signing-php package). Read here for convenience.
    |
    */

    'api_secret' => env('AUTOZNETWORK_API_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | OAuth (sign in with autoZnetwork)
    |--------------------------------------------------------------------------
    */

    'auth_url' => env('AUTOZNETWORK_AUTH_URL', 'https://autoznetwork.com'),

    'client_id' => env('AUTOZNETWORK_CLIENT_ID'),

    'client_secret' => env('AUTOZNETWORK_CLIENT_SECRET'),

    'redirect_url' => env('AUTOZNETWORK_REDIRECT_URL'),

    'scopes' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Timeouts (seconds)
    |--------------------------------------------------------------------------
    */

    'timeout' => [
        'connect' => (int) env('AUTOZNETWORK_CONNECT_TIMEOUT', 5),
        'request' => (int) env('AUTOZNETWORK_TIMEOUT', 30),
    ],

];
