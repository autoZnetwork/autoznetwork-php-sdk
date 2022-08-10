<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Requests\Request;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class CreateInventoryRequest extends Request
{
    use HasJsonBody;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::POST;

    /**
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/inventory';
    }

    public function __construct(
        public array $data
    ) {
    }

    public function defaultData(): array
    {
        return $this->data;
    }
}
