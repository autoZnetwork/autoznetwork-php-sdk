<?php

namespace Autoznetwork\AutozNetwork\Requests\Inventory;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListInventoryRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $params
     */
    public function __construct(
        protected readonly array $params = [],
        protected readonly ?string $sort = null,
        protected readonly ?string $direction = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inventory';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        $query = $this->params;

        if ($this->sort !== null) {
            $query['sort'] = $this->sort;

            if ($this->direction !== null) {
                $query['sort_direction'] = $this->direction;
            }
        }

        return $query;
    }
}
