<?php

namespace AutozNetwork\Requests\Locations;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListLocationsRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function __construct(public array $params)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/locations';
    }

    public function defaultQuery(): array
    {
        return $this->params;
    }
}
