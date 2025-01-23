<?php

namespace AutozNetwork\Resources\Vehicle;

use AutozNetwork\Requests\Vehicle\Filters\ListFiltersRequest;
use AutozNetwork\Resources\BaseResource;

class FilterResource extends BaseResource
{
    public function all(array $only = []): mixed
    {
        return $this->connector->send(new ListFiltersRequest($only))->json();
    }
}
