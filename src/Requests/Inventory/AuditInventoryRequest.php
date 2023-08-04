<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class AuditInventoryRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::POST;

    public function __construct(public array $vehicles)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/inventory/audit';
    }

    public function defaultBody(): array
    {
        return [
            'vehicles' => $this->vehicles,
        ];
    }
}
