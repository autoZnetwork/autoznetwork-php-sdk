<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Autoznetwork\AutozNetwork\Requests\Organizations\GetOrganizationRequest;
use Autoznetwork\AutozNetwork\Requests\Organizations\ListOrganizationsRequest;
use Autoznetwork\AutozNetwork\Requests\Organizations\UpdateBannersRequest;

class OrganizationResource extends BaseResource
{
    /**
     * The organizations the token can see. Works unscoped.
     */
    public function all(): mixed
    {
        return $this->connector->send(new ListOrganizationsRequest)->json();
    }

    /**
     * Works unscoped; `include=enterprise` and friends through `$params` or `with()`.
     *
     * @param  array<string, mixed>  $params
     */
    public function get(int $id, array $params = []): mixed
    {
        return $this->connector->send(new GetOrganizationRequest($id, $this->formatParams($params)))->json();
    }

    /**
     * Replace the organization's search banners.
     *
     * @param  array<int, array<string, mixed>>  $banners
     */
    public function updateBanners(array $banners): mixed
    {
        return $this->connector->send(new UpdateBannersRequest($banners))->json();
    }
}
