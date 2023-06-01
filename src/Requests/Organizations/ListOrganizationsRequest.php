<?php

namespace AutozNetwork\Requests\Organizations;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class ListOrganizationsRequest extends Request
{
    use AcceptsJson;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/organizations';
    }
}
