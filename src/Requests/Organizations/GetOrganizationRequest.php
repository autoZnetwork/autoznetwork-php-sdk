<?php

namespace AutozNetwork\Requests\Organizations;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class GetOrganizationRequest extends Request
{
    use AcceptsJson;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/organizations/$this->organizationId";
    }

    public function __construct(public int $organizationId)
    {
    }
}
