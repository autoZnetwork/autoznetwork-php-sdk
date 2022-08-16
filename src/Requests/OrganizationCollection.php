<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Organizations\GetOrganizationRequest;
use AutozNetwork\Requests\Organizations\ListOrganizationsRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class OrganizationCollection extends RequestCollection
{
    public function all()
    {
        $request = $this->connector->request(new ListOrganizationsRequest);
        $response = $request->send();

        return $response->json();
    }

    public function get(int $id)
    {
        $request = $this->connector->request(new GetOrganizationRequest($id));
        $response = $request->send();

        return $response->json();
    }
}
