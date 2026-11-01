<?php

namespace Autoznetwork\AutozNetwork\Requests\Locations;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetLocationRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    public function __construct(
        protected readonly int $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/locations/$this->id";
    }
}
