<?php

namespace AutozNetwork\Plugins;

use Sammyjo20\Saloon\Http\SaloonRequest;

trait WithOrganizationID
{
    public int $organizationId;

    public function bootWithOrganizationID(SaloonRequest $request): void
    {
        $request->mergeHeaders([
            'X-Organization-ID' => $this->organizationId,
        ]);
    }

    public function organization(int $organizationId): static
    {
        $this->organizationId = $organizationId;

        return $this;
    }

    public function withOrganization(int $organizationId): static
    {
        return $this->organization($organizationId);
    }
}
