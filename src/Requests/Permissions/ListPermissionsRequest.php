<?php

namespace AutozNetwork\Requests\Permissions;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListPermissionsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/permissions';
    }
}
