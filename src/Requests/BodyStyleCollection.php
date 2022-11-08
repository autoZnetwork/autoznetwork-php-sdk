<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\BodyStyles\GetBodyStyleRequest;
use AutozNetwork\Requests\BodyStyles\ListBodyStylesRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class BodyStyleCollection extends RequestCollection
{
    public function all()
    {
        $request = $this->connector->request(new ListBodyStylesRequest);
        $response = $request->send();

        return $response->json();
    }

    public function get(int $id)
    {
        $request = $this->connector->request(new GetBodyStyleRequest($id));
        $response = $request->send();

        return $response->json();
    }
}
