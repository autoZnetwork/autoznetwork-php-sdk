<?php

namespace Autoznetwork\AutozNetwork\Requests\Inventory;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateInventoryRequest extends Request implements HasBody
{
    use HasJsonBody;
    use RequiresEntityId;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $data
     */
    public function __construct(
        protected readonly array $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inventory';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->data;
    }
}
