<?php

namespace AutozNetwork\Requests\Syndications;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListSyndicationsRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/syndications';
    }
}
