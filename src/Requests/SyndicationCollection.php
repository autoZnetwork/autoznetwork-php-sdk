<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Syndications\DeleteFeedRequest;
use AutozNetwork\Requests\Syndications\GetFeedRequest;
use AutozNetwork\Requests\Syndications\ListFeedsRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class SyndicationCollection extends RequestCollection
{
    public function all()
    {
        $request = $this->connector->request(new ListFeedsRequest);
        $response = $request->send();

        return $response->json();
    }

    public function get(int $id)
    {
        $request = $this->connector->request(new GetFeedRequest($id));
        $response = $request->send();

        return $response->json();
    }

    public function delete(int $id)
    {
        $request = $this->connector->request(new DeleteFeedRequest($id));
        $response = $request->send();

        return $response->json();
    }
}
