<?php

namespace AutozNetwork\Resources\Careers;

use AutozNetwork\Requests\Careers\Posts\ListCareerPostsRequest;
use AutozNetwork\Resources\BaseResource;

class CareerPostResource extends BaseResource
{
    public function all(array $params = []): mixed
    {
        return $this->connector->send(new ListCareerPostsRequest(
            params: $this->formatParams($params),
            sort: $this->sort,
            direction: $this->direction,
        ))->json();
    }
}
