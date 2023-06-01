<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\BodyStyles\GetBodyStyleRequest;
use AutozNetwork\Requests\BodyStyles\ListBodyStylesRequest;
use Saloon\Http\Response;

class BodyStyleResource extends BaseResource
{
    public function all(): Response
    {
        return $this->connector->send(new ListBodyStylesRequest())->json();
    }

    public function get(int $id): Response
    {
        return $this->connector->send(new GetBodyStyleRequest($id))->json();
    }
}
