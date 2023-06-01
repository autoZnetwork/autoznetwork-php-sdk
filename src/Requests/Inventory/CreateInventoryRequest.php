<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AcceptsJson;

class CreateInventoryRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/inventory';
    }

    public function __construct(public array $data)
    {
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
