<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Organizations\GetOrganizationRequest;
use AutozNetwork\Requests\Organizations\ListOrganizationsRequest;

class OrganizationResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListOrganizationsRequest())->json();
    }

    public function get(int $id): mixed
    {
        return $this->connector->send(new GetOrganizationRequest($id))->json();
    }
}
