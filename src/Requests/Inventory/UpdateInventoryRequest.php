<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Requests\Request;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class UpdateInventoryRequest extends Request
{
    use HasJsonBody;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::PUT;

    /**
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/inventory/'.$this->inventoryId;
    }

    public function __construct(
        public int $inventoryId,
        public array $data
    ) {
    }

    public function defaultData(): array
    {
        return $this->data;
    }
}
