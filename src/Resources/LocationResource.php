<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Autoznetwork\AutozNetwork\Requests\Locations\CreateLocationRequest;
use Autoznetwork\AutozNetwork\Requests\Locations\DeleteLocationRequest;
use Autoznetwork\AutozNetwork\Requests\Locations\GetLocationRequest;
use Autoznetwork\AutozNetwork\Requests\Locations\ListLocationsRequest;

/**
 * An organization's rooftops.
 */
class LocationResource extends BaseResource
{
    /**
     * @param  array<string, mixed>  $params
     */
    public function all(array $params = []): mixed
    {
        return $this->connector->send(new ListLocationsRequest($this->formatParams($params)))->json();
    }

    /**
     * By id, or by a slug that starts with the id (`12-main-street`).
     */
    public function get(int|string $id): mixed
    {
        $id = is_numeric($id) ? (int) $id : (int) explode('-', (string) $id)[0];

        return $this->connector->send(new GetLocationRequest($id))->json();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): mixed
    {
        return $this->connector->send(new CreateLocationRequest($data))->json();
    }

    public function delete(int $id): mixed
    {
        return $this->connector->send(new DeleteLocationRequest($id))->json();
    }
}
