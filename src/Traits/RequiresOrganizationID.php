<?php

namespace AutozNetwork\Traits;

use Saloon\Exceptions\MissingAuthenticatorException;
use Saloon\Http\PendingRequest;

trait RequiresOrganizationID
{
    /**
     * Throw an exception if there was no organization id while it is booting.
     *
     * @throws MissingAuthenticatorException
     */
    public function bootRequiresOrganizationId(PendingRequest $pendingRequest): void
    {
        if (! $pendingRequest->headers()->get('X-AutozNetwork-Organization-Id')) {
            throw new MissingAuthenticatorException($this->getRequiresOrganizationId($pendingRequest));
        }
    }

    /**
     * Default message.
     */
    protected function getRequiresOrganizationId(PendingRequest $request): string
    {
        return sprintf('The "%s" request requires an organization ID. Please provide an organization ID using the `withOrganization` method.', $request::class);
    }
}
