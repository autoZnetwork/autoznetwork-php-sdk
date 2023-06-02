<?php

namespace AutozNetwork\Plugins;

use Saloon\Http\PendingRequest;

trait WithOrganizationID
{
    public ?int $organizationId = null;

    public function bootWithOrganizationID(PendingRequest $pendingRequest): void
    {
        if (! is_null($this->organizationId)) {
            $pendingRequest->headers()->merge([
                'X-AutozNetwork-Organization-Id' => $this->organizationId,
            ]);
        }
    }

    public function organization(?int $organizationId): static
    {
        $this->organizationId = $organizationId;

        return $this;
    }

    public function withOrganization(?int $organizationId): static
    {
        return $this->organization($organizationId);
    }
}
