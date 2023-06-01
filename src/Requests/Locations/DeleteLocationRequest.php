<?php

namespace AutozNetwork\Requests\Locations;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AcceptsJson;

class DeleteLocationRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/locations/$this->locationId";
    }

    public function __construct(public int $locationId)
    {
    }
}
