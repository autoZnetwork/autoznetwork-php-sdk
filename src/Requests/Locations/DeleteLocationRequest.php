<?php

namespace AutozNetwork\Requests\Locations;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteLocationRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::DELETE;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/locations/$this->id";
    }
}
