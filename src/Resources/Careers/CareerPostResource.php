<?php

namespace Autoznetwork\AutozNetwork\Resources\Careers;

use Autoznetwork\AutozNetwork\Requests\Careers\Posts\ListCareerPostsRequest;
use Autoznetwork\AutozNetwork\Resources\BaseResource;

class CareerPostResource extends BaseResource
{
    /**
     * Active, listed job posts.
     *
     * @param  array<string, mixed>  $params
     */
    public function all(array $params = []): mixed
    {
        return $this->connector->send(new ListCareerPostsRequest(
            params: $this->formatParams($params),
            sort: $this->sort,
            direction: $this->direction,
        ))->json();
    }
}
