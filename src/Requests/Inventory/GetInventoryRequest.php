<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Requests\Request;
use Sammyjo20\Saloon\Constants\Saloon;

class GetInventoryRequest extends Request
{
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
        return '/inventory'.$this->inventoryId;
    }

    public function __construct(
        public int $inventoryId
    ) {
    }
}
