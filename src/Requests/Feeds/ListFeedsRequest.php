<?php

namespace AutozNetwork\Requests\Feeds;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListFeedsRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/feeds';
    }
}
