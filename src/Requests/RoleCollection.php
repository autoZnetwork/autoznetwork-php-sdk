<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Roles\ListRolesRequest;
use AutozNetwork\Requests\Roles\GetRoleRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class RoleCollection extends RequestCollection
{
    public function all()
    {
        $request = $this->connector->request(new ListRolesRequest());
        $response = $request->send();

        return $response->json();
    }

    public function get(int $id)
    {
        $request = $this->connector->request(new GetRoleRequest($id));
        $response = $request->send();

        return $response->json();
    }
}
