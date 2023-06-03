<?php

namespace AutozNetwork\Requests\Feeds;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteFeedRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::DELETE;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/feeds/$this->id";
    }
}
