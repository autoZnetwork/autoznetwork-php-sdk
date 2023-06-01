<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Roles\GetRoleRequest;
use AutozNetwork\Requests\Roles\ListRolesRequest;
use Saloon\Http\Response;

class RoleResource extends BaseResource
{
    public function all(): Response
    {
        return $this->connector->send(new ListRolesRequest())->json();
    }

    public function get(int $id): Response
    {
        return $this->connector->send(new GetRoleRequest($id))->json();
    }
}
