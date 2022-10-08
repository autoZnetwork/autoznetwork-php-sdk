<?php

namespace AutozNetwork\Plugins;

use Sammyjo20\Saloon\Http\SaloonRequest;

trait WithOrganizationID
{
    public ?int $organizationId = null;

    public function bootWithOrganizationID(SaloonRequest $request): void
    {
        if (! is_null($this->organizationId)) {
            $request->mergeHeaders([
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
