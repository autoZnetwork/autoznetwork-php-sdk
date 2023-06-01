<?php

namespace AutozNetwork\Requests\Permissions;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class ListPermissionsRequest extends Request
{
    use AcceptsJson;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/permissions';
    }
}
