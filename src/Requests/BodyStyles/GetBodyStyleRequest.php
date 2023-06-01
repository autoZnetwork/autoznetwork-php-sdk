<?php

namespace AutozNetwork\Requests\BodyStyles;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class GetBodyStyleRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/vehicles/body-styles/$this->bodyStyleId";
    }

    public function __construct(public int $bodyStyleId)
    {
    }
}
