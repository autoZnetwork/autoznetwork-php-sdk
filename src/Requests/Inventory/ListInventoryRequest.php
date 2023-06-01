<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class ListInventoryRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/inventory';
    }

    public function __construct(
        public array $params,
        public ?string $sort = null,
        public ?string $direction = null,
    ) {
    }

    public function defaultQuery(): array
    {
        if ($this->sort) {
            $this->params['sort'] = $this->sort;

            if ($this->direction) {
                $this->params['sort_direction'] = $this->direction;
            }
        }

        return $this->params;
    }
}
