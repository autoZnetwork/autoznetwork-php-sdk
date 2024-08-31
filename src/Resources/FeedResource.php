<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Feeds\CreateFeedRequest;
use AutozNetwork\Requests\Feeds\DeleteFeedRequest;
use AutozNetwork\Requests\Feeds\GetFeedRequest;
use AutozNetwork\Requests\Feeds\ListFeedsRequest;

class FeedResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListFeedsRequest)->json();
    }

    public function get(int $id): mixed
    {
        return $this->connector->send(new GetFeedRequest($id))->json();
    }

    public function create(array $data): mixed
    {
        return $this->connector->send(new CreateFeedRequest($data))->json();
    }

    public function delete(int $id): mixed
    {
        return $this->connector->send(new DeleteFeedRequest($id))->json();
    }
}
