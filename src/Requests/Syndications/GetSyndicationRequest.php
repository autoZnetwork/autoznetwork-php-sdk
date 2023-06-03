<?php

namespace AutozNetwork\Requests\Syndications;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetSyndicationRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/syndications/$this->id";
    }
}
