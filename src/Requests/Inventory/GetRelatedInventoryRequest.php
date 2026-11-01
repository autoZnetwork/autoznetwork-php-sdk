<?php

namespace Autoznetwork\AutozNetwork\Requests\Inventory;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Vehicles similar to one vehicle, for "you may also like" rails.
 */
class GetRelatedInventoryRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    public function __construct(
        protected readonly int $id,
        protected readonly int $limit = 4,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/inventory/$this->id/related";
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return [
            'limit' => $this->limit,
        ];
    }
}
