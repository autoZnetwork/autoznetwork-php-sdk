<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Syndications\CreateSyndicationRequest;
use AutozNetwork\Requests\Syndications\DeleteSyndicationRequest;
use AutozNetwork\Requests\Syndications\GetSyndicationRequest;
use AutozNetwork\Requests\Syndications\ListSyndicationsRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class SyndicationCollection extends RequestCollection
{
    public function all()
    {
        $request = $this->connector->request(new ListSyndicationsRequest());
        $response = $request->send();

        return $response->json();
    }

    public function get(int $id)
    {
        $request = $this->connector->request(new GetSyndicationRequest($id));
        $response = $request->send();

        return $response->json();
    }

    public function create(array $data)
    {
        $request = $this->connector->request(new CreateSyndicationRequest($data));
        $response = $request->send();

        return $response->json();
    }

    public function delete(int $id)
    {
        $request = $this->connector->request(new DeleteSyndicationRequest($id));
        $response = $request->send();

        return $response->json();
    }
}
