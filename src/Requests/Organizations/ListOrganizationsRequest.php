<?php

namespace AutozNetwork\Requests\Organizations;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListOrganizationsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/organizations';
    }
}
