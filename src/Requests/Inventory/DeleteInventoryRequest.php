<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteInventoryRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::DELETE;

    public function __construct(public int $id) {}

    public function resolveEndpoint(): string
    {
        return '/inventory/'.$this->id;
    }
}
