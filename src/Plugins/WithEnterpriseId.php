<?php

namespace Autoznetwork\AutozNetwork\Plugins;

use Autoznetwork\AutozNetwork\Enums\EntityType;
use NoDiscard;
use Saloon\Http\PendingRequest;

/**
 * Scopes requests to one enterprise (a dealership group) through the tenant header.
 */
trait WithEnterpriseId
{
    protected ?string $enterpriseId = null;

    public function bootWithEnterpriseId(PendingRequest $pendingRequest): void
    {
        if ($this->enterpriseId !== null) {
            $pendingRequest->headers()->merge([
                EntityType::ENTERPRISE->header() => $this->enterpriseId,
            ]);
        }
    }

    /**
     * A copy of this client scoped to the given enterprise, or unscoped for null.
     */
    #[NoDiscard('withEnterprise() returns a new client; the one it was called on is unchanged')]
    public function withEnterprise(int|string|null $enterpriseId): static
    {
        $scoped = clone $this;
        $scoped->enterpriseId = $enterpriseId === null ? null : (string) $enterpriseId;

        return $scoped;
    }

    public function enterpriseId(): ?string
    {
        return $this->enterpriseId;
    }
}
