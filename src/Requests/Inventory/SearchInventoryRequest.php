<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class SearchInventoryRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function __construct(
        public array $params,
        public ?string $searchTerm = null,
        public ?string $sort = null,
        public ?string $direction = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/inventory/search';
    }

    public function defaultQuery(): array
    {
        $this->params['query'] = $this->searchTerm;

        if ($this->sort) {
            $this->params['sort'] = $this->sort;

            if ($this->direction) {
                $this->params['sort_direction'] = $this->direction;
            }
        }

        return $this->params;
    }
}
