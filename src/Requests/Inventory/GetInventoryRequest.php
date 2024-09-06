<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetInventoryRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function __construct(
        public int $id,
        public array $params = [],
        public bool $cache = true,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/inventory/$this->id";
    }

    public function defaultQuery(): array
    {
        if (! $this->cache) {
            $this->params['no-cache'] = $this->cache;
        }

        return $this->params;
    }
}
