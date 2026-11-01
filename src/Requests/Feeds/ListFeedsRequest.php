<?php

namespace Autoznetwork\AutozNetwork\Requests\Feeds;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListFeedsRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/feeds';
    }
}
