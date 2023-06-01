<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class CreateInventoryImageRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    protected bool $removeBackground = false;

    protected ?string $removeBackgroundWebhookUrl;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/inventory';
    }

    public function __construct(public array $filters)
    {
    }

    public function defaultBody(): array
    {
        return $this->filters;
    }

    public function removeBackground(): static
    {
        $this->removeBackground = true;

        return $this;
    }

    public function removeBackgroundWebhookUrl($webhookUrl): static
    {
        $this->removeBackgroundWebhookUrl = $webhookUrl;

        return $this;
    }
}
