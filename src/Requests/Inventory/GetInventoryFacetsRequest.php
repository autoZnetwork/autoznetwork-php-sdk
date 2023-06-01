<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class GetInventoryFacetsRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/inventory_facets';
    }

    public function __construct(public array $params = [])
    {
    }

    public function defaultQuery(): array
    {
        return $this->params;
    }
}
