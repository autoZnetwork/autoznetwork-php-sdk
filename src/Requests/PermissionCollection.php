<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Permissions\GetPermissionRequest;
use AutozNetwork\Requests\Permissions\ListPermissionsRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class PermissionCollection extends RequestCollection
{
    public function all()
    {
        $request = $this->connector->request(new ListPermissionsRequest());
        $response = $request->send();

        return $response->json();
    }

    public function get(int $id)
    {
        $request = $this->connector->request(new GetPermissionRequest($id));
        $response = $request->send();

        return $response->json();
    }
}
