<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateInventoryRequest extends Request implements HasBody
{
    use HasJsonBody;
    use RequiresEntityID;

    protected Method $method = Method::PUT;

    public function __construct(
        public int $id,
        public array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/inventory/$this->id";
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
