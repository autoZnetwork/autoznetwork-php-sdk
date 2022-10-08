<?php

namespace AutozNetwork\Requests\Inventory;

use AutozNetwork\Requests\Request;
use AutozNetwork\Traits\RequiresOrganizationID;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;

class CreateInventoryImageRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    private bool $removeBackground = false;

    private ?string $removeBackgroundWebhookUrl;

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
        public array $filters
    ) {
    }

    public function defaultData(): array
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
