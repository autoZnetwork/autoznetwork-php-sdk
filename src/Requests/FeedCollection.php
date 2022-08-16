<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Feeds\DeleteFeedRequest;
use AutozNetwork\Requests\Feeds\GetFeedRequest;
use AutozNetwork\Requests\Feeds\ListFeedsRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class FeedCollection extends RequestCollection
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
