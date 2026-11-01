<?php

namespace Autoznetwork\AutozNetwork\Resources\Vehicle;

use Autoznetwork\AutozNetwork\Requests\Vehicle\BodyStyles\ListBodyStylesRequest;
use Autoznetwork\AutozNetwork\Resources\BaseResource;

class BodyStyleResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListBodyStylesRequest(
            sort: $this->sort,
            direction: $this->direction,
        ))->json();
    }
}
