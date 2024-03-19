<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetInventoryFacetsRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function __construct(public array $params = [])
    {
    }

    public function resolveEndpoint(): string
    {
        return '/inventory_facets';
    }

    public function defaultQuery(): array
    {
        return $this->params;
    }
}
