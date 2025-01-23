<?php

namespace AutozNetwork\Resources\Vehicle;

use AutozNetwork\Requests\Vehicle\BodyStyles\GetBodyStyleRequest;
use AutozNetwork\Requests\Vehicle\BodyStyles\ListBodyStylesRequest;
use AutozNetwork\Resources\BaseResource;

class BodyStyleResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListBodyStylesRequest(
            sort: $this->sort,
            direction: $this->direction,
        ))->json();
    }

    public function get(int $id): mixed
    {
        return $this->connector->send(new GetBodyStyleRequest($id))->json();
    }
}
