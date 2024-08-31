<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Organizations\GetOrganizationRequest;
use AutozNetwork\Requests\Organizations\ListOrganizationsRequest;
use AutozNetwork\Requests\Organizations\UpdateBannersRequest;

class OrganizationResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListOrganizationsRequest)->json();
    }

    public function get(int $id, array $params = []): mixed
    {
        return $this->connector->send(new GetOrganizationRequest($id, $params))->json();
    }

    public function updateBanners(array $banners): mixed
    {
        return $this->connector->send(new UpdateBannersRequest($banners))->json();
    }
}
