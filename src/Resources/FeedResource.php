<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Feeds\CreateFeedRequest;
use AutozNetwork\Requests\Feeds\DeleteFeedRequest;
use AutozNetwork\Requests\Feeds\GetFeedRequest;
use AutozNetwork\Requests\Feeds\ListFeedsRequest;
use Saloon\Http\Response;

class FeedResource extends BaseResource
{
    public function all(): Response
    {
        return $this->connector->send(new ListFeedsRequest())->json();
    }

    public function get(int $id): Response
    {
        return $this->connector->send(new GetFeedRequest($id))->json();
    }

    public function create(array $data): Response
    {
        return $this->connector->send(new CreateFeedRequest($data))->json();
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(new DeleteFeedRequest($id))->json();
    }
}
