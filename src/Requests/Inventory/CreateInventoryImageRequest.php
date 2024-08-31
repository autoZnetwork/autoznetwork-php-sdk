<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class CreateInventoryImageRequest extends Request
{
    use RequiresEntityID;

    protected bool $removeBackground = false;

    protected ?string $removeBackgroundWebhookUrl;

    protected Method $method = Method::POST;

    public function __construct(public array $filters) {}

    public function resolveEndpoint(): string
    {
        return '/inventory';
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
