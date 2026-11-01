<?php

namespace Autoznetwork\AutozNetwork\Resources\Vehicle;

use Autoznetwork\AutozNetwork\Requests\Vehicle\Filters\ListFiltersRequest;
use Autoznetwork\AutozNetwork\Resources\BaseResource;

class FilterResource extends BaseResource
{
    /**
     * @param  list<string>  $only  limit the response to these filter groups
     */
    public function all(array $only = []): mixed
    {
        return $this->connector->send(new ListFiltersRequest($only))->json();
    }
}
