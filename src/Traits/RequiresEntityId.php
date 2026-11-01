<?php

namespace Autoznetwork\AutozNetwork\Traits;

use Autoznetwork\AutozNetwork\Enums\EntityType;
use Saloon\Exceptions\MissingAuthenticatorException;
use Saloon\Http\PendingRequest;

/**
 * For requests that only make sense inside an organization or enterprise.
 */
trait RequiresEntityId
{
    /**
     * @throws MissingAuthenticatorException when the client was not scoped
     */
    public function bootRequiresEntityId(PendingRequest $pendingRequest): void
    {
        $headers = $pendingRequest->headers();

        if (! $headers->get(EntityType::ORGANIZATION->header()) && ! $headers->get(EntityType::ENTERPRISE->header())) {
            throw new MissingAuthenticatorException(sprintf(
                'The %s request needs an organization or enterprise: scope the client with withOrganization(), withEnterprise() or withEntity().',
                static::class,
            ));
        }
    }
}
