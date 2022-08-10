<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Locations\DeleteLocationRequest;
use AutozNetwork\Requests\Locations\GetLocationRequest;
use AutozNetwork\Requests\Locations\ListLocationsRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class LocationCollection extends RequestCollection
{
    public function all()
    {
        $request = $this->connector->request(new ListLocationsRequest);
        $response = $request->send();

        return $response->json();
    }

    public function get(int $id)
    {
        $request = $this->connector->request(new GetLocationRequest($id));
        $response = $request->send();

        return $response->json();
    }

    public function delete(int $id)
    {
        $request = $this->connector->request(new DeleteLocationRequest($id));
        $response = $request->send();

        return $response->json();
    }
}
