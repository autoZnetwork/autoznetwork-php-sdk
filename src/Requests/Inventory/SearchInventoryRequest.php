<?php

namespace Autoznetwork\AutozNetwork\Requests\Inventory;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Full-text search over inventory.
 */
class SearchInventoryRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $params
     */
    public function __construct(
        protected readonly array $params = [],
        protected readonly ?string $searchTerm = null,
        protected readonly ?string $sort = null,
        protected readonly ?string $direction = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inventory/search';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        $query = [...$this->params, 'query' => $this->searchTerm];

        if ($this->sort !== null) {
            $query['sort'] = $this->sort;

            if ($this->direction !== null) {
                $query['sort_direction'] = $this->direction;
            }
        }

        return $query;
    }
}
