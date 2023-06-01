<?php

namespace AutozNetwork\Requests\Feeds;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class GetFeedRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/feeds.$this->feedId";
    }

    public function __construct(public int $feedId)
    {
    }
}
