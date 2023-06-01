<?php

namespace AutozNetwork\Requests\Syndications;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class GetSyndicationRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/syndications/$this->syndicationId";
    }

    public function __construct(public int $syndicationId)
    {
    }
}
