<?php

namespace Autoznetwork\AutozNetwork\Requests\Inventory;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteInventoryRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::DELETE;

    public function __construct(
        protected readonly int $id,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/inventory/$this->id";
    }
}
