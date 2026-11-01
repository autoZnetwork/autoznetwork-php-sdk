<?php

namespace Autoznetwork\AutozNetwork\Requests\Syndications;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListSyndicationsRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/syndications';
    }
}
