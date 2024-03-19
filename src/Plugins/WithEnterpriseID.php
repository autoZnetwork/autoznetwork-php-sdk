<?php

namespace AutozNetwork\Plugins;

use Saloon\Http\PendingRequest;

trait WithEnterpriseID
{
    public ?int $enterpriseId = null;

    public function bootWithEnterpriseID(PendingRequest $pendingRequest): void
    {
        if (! is_null($this->enterpriseId)) {
            $pendingRequest->headers()->merge([
                'X-AutozNetwork-Enterprise-Id' => $this->enterpriseId,
            ]);
        }
    }

    public function enterprise(?int $enterpriseId): static
    {
        $this->enterpriseId = $enterpriseId;

        return $this;
    }

    public function withEnterprise(?int $enterpriseId): static
    {
        return $this->enterprise($enterpriseId);
    }
}
