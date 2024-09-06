<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Roles\GetRoleRequest;
use AutozNetwork\Requests\Roles\ListRolesRequest;

class RoleResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListRolesRequest)->json();
    }

    public function get(int $id): mixed
    {
        return $this->connector->send(new GetRoleRequest($id))->json();
    }
}
