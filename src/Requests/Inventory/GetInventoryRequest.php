<?php

namespace Autoznetwork\AutozNetwork\Requests\Inventory;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetInventoryRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $params
     * @param  bool  $cache  false asks the API for a fresh copy (`no-cache`)
     */
    public function __construct(
        protected readonly int $id,
        protected readonly array $params = [],
        protected readonly bool $cache = true,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/inventory/$this->id";
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return $this->cache
            ? $this->params
            : [...$this->params, 'no-cache' => false];
    }
}
