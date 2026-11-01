<?php

namespace Autoznetwork\AutozNetwork\Plugins;

use Autoznetwork\AutozNetwork\Enums\EntityType;
use NoDiscard;
use Saloon\Http\PendingRequest;

/**
 * Scopes requests to one organization through the tenant header.
 *
 * The scope lives on a copy of the client, never on the client it was asked
 * of, so a shared instance cannot leak one tenant's id into another's request.
 */
trait WithOrganizationId
{
    protected ?string $organizationId = null;

    public function bootWithOrganizationId(PendingRequest $pendingRequest): void
    {
        if ($this->organizationId !== null) {
            $pendingRequest->headers()->merge([
                EntityType::ORGANIZATION->header() => $this->organizationId,
            ]);
        }
    }

    /**
     * A copy of this client scoped to the given organization, or unscoped for null.
     */
    #[NoDiscard('withOrganization() returns a new client; the one it was called on is unchanged')]
    public function withOrganization(int|string|null $organizationId): static
    {
        $scoped = clone $this;
        $scoped->organizationId = $organizationId === null ? null : (string) $organizationId;

        return $scoped;
    }

    public function organizationId(): ?string
    {
        return $this->organizationId;
    }
}
