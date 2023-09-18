<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRelatedInventoryRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function __construct(
        public int $id,
        public int $limit,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/inventory/$this->id/related";
    }

    public function defaultQuery(): array
    {
        return [
            'limit' => $this->limit,
        ];
    }
}
