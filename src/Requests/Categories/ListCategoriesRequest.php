<?php

namespace Autoznetwork\AutozNetwork\Requests\Categories;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListCategoriesRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    public function __construct(
        protected readonly ?string $sort = null,
        protected readonly ?string $direction = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/vehicle/categories';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        $query = [];

        if ($this->sort !== null) {
            $query['sort'] = $this->sort;

            if ($this->direction !== null) {
                $query['sort_direction'] = $this->direction;
            }
        }

        return $query;
    }
}
