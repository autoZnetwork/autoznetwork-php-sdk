<?php

namespace Autoznetwork\AutozNetwork\Requests\Locations;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteLocationRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::DELETE;

    public function __construct(
        protected readonly int $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/locations/$this->id";
    }
}
