<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Locations\CreateLocationRequest;
use AutozNetwork\Requests\Locations\DeleteLocationRequest;
use AutozNetwork\Requests\Locations\GetLocationRequest;
use AutozNetwork\Requests\Locations\ListLocationsRequest;

class LocationResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListLocationsRequest())->json();
    }

    public function get(string|int $id): mixed
    {
        $id = is_numeric($id)
            ? $id
            : explode('-', $id)[0];

        return $this->connector->send(new GetLocationRequest($id))->json();
    }

    public function create(array $data): mixed
    {
        return $this->connector->send(new CreateLocationRequest($data))->json();
    }

    public function delete(int $id): mixed
    {
        return $this->connector->send(new DeleteLocationRequest($id))->json();
    }
}
