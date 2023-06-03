<?php

namespace AutozNetwork\Requests\Syndications;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListSyndicationsRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/syndications';
    }
}
