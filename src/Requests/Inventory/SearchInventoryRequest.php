<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Requests\Request;
use AutozNetwork\Traits\RequiresOrganizationID;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;

class SearchInventoryRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::GET;

    /**
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/inventory/search';
    }

    public function __construct(
        public array $filters,
        public ?string $searchTerm = null
    ) {
    }

    public function defaultData(): array
    {
        $filters = $this->filters;
        $filters['query'] = $this->searchTerm;

        return $filters;
    }
}
