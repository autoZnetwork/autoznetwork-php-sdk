<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\BodyStyles\GetBodyStyleRequest;
use AutozNetwork\Requests\BodyStyles\ListBodyStylesRequest;

class BodyStyleResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListBodyStylesRequest())->json();
    }

    public function get(int $id): mixed
    {
        return $this->connector->send(new GetBodyStyleRequest($id))->json();
    }
}
