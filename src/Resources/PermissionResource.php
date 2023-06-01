<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Permissions\GetPermissionRequest;
use AutozNetwork\Requests\Permissions\ListPermissionsRequest;
use Saloon\Http\Response;

class PermissionResource extends BaseResource
{
    public function all(): Response
    {
        return $this->connector->send(new ListPermissionsRequest())->json();
    }

    public function get(int $id): Response
    {
        return $this->connector->send(new GetPermissionRequest($id))->json();
    }
}
