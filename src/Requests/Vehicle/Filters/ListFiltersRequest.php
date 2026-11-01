<?php

namespace Autoznetwork\AutozNetwork\Requests\Vehicle\Filters;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * The filter groups (makes, body styles, price bands, ...) a storefront can offer.
 */
class ListFiltersRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    /**
     * @param  list<string>  $only
     */
    public function __construct(
        protected readonly array $only = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/vehicle/filters';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return $this->only === []
            ? []
            : ['only' => implode(',', $this->only)];
    }
}
