<?php

namespace AutozNetwork\Requests\Locations;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class GetLocationRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/locations/$this->locationId";
    }

    public function __construct(public int $locationId)
    {
    }
}
