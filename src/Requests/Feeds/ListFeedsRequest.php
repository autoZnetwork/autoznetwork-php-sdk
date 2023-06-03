<?php

namespace AutozNetwork\Requests\Feeds;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListFeedsRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/feeds';
    }
}
