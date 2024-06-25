<?php

namespace AutozNetwork\Requests\Enterprises;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListEnterprisesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/enterprises';
    }
}
