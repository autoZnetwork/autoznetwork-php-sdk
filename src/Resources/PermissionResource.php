<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Permissions\GetPermissionRequest;
use AutozNetwork\Requests\Permissions\ListPermissionsRequest;

class PermissionResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListPermissionsRequest())->json();
    }

    public function get(int $id): mixed
    {
        return $this->connector->send(new GetPermissionRequest($id))->json();
    }
}
