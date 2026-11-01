<?php

namespace Autoznetwork\AutozNetwork\Requests\Inventory;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Compare a list of vehicles against inventory and report the differences.
 */
class AuditInventoryRequest extends Request implements HasBody
{
    use HasJsonBody;
    use RequiresEntityId;

    protected Method $method = Method::POST;

    /**
     * @param  array<int, array<string, mixed>>  $vehicles
     */
    public function __construct(
        protected readonly array $vehicles,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/inventory/audit';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'vehicles' => $this->vehicles,
        ];
    }
}
