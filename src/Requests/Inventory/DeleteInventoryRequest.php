<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Requests\Request;
use AutozNetwork\Traits\RequiresOrganizationID;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class DeleteInventoryRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;
    use RequiresOrganizationID;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::DELETE;

    /**
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/inventory/'.$this->inventoryId;
    }

    public function __construct(
        public int $inventoryId
    ) {
    }
}
