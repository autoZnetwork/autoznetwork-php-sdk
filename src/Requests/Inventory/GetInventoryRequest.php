<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class GetInventoryRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/inventory/$this->inventoryId";
    }

    public function __construct(
        public int $inventoryId,
        public array $params = [],
        public bool $cache = true,
    ) {
    }

    public function defaultQuery(): array
    {
        if (! $this->cache) {
            $this->params['no-cache'] = $this->cache;
        }

        return $this->params;
    }
}
