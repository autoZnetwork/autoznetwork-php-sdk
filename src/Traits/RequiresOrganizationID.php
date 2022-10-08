<?php

namespace AutozNetwork\Traits;

use Sammyjo20\Saloon\Exceptions\MissingAuthenticatorException;
use Sammyjo20\Saloon\Http\SaloonRequest;

trait RequiresOrganizationID
{
    /**
     * Throw an exception if there was no organization id while it is booting.
     *
     * @param  SaloonRequest  $request
     * @return void
     *
     * @throws MissingAuthenticatorException
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonInvalidConnectorException
     */
    public function bootRequiresOrganizationId(SaloonRequest $request): void
    {
        if (! isset($request->getHeaders()['X-AutozNetwork-Organization-Id'])) {
            throw new MissingAuthenticatorException($this->getRequiresOrganizationId($request));
        }
    }

    /**
     * Default message.
     *
     * @param  SaloonRequest  $request
     * @return string
     */
    protected function getRequiresOrganizationId(SaloonRequest $request): string
    {
        return sprintf('The "%s" request requires an organization ID. Please provide an organization ID using the `withOrganization` method.', $request::class);
    }
}
