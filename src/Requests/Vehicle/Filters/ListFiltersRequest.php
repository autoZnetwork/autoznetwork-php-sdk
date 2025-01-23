<?php

namespace AutozNetwork\Requests\Vehicle\Filters;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListFiltersRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function __construct(public array $only = []) {}

    public function resolveEndpoint(): string
    {
        return '/vehicle/filters';
    }

    public function defaultQuery(): array
    {
        return array_filter([
            'only' => count($this->only) > 0
                ? implode(',', $this->only)
                : null,
        ]);
    }
}
