<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Inventory\CreateInventoryRequest;
use AutozNetwork\Requests\Inventory\DeleteInventoryRequest;
use AutozNetwork\Requests\Inventory\GetInventoryFacetsRequest;
use AutozNetwork\Requests\Inventory\GetInventoryRequest;
use AutozNetwork\Requests\Inventory\ListInventoryRequest;
use AutozNetwork\Requests\Inventory\SearchInventoryRequest;
use AutozNetwork\Requests\Inventory\UpdateInventoryRequest;

class InventoryResource extends BaseResource
{
    protected bool $cache = true;

    protected ?string $sort = null;

    protected ?string $direction = null;

    public function withoutCache(): self
    {
        $this->cache = false;

        return $this;
    }

    public function all($params = []): mixed
    {
        return $this->connector->send(
            new ListInventoryRequest($params, $this->sort, $this->direction)
        )->json();
    }

    public function search($params = [], $searchTerm = null): mixed
    {
        return $this->connector->send(
            new SearchInventoryRequest($params, $searchTerm, $this->sort, $this->direction)
        )->json();
    }

    public function facets($params = []): mixed
    {
        return $this->connector->send(new GetInventoryFacetsRequest($params))->json();
    }

    public function get(int $id, array $params): mixed
    {
        return $this->connector->send(new GetInventoryRequest($id, $params, $this->cache))->json();
    }

    public function create(array $data): mixed
    {
        return $this->connector->send(new CreateInventoryRequest($data))->json();
    }

    public function update(int $id, array $data): mixed
    {
        return $this->connector->send(new UpdateInventoryRequest($id, $data))->json();
    }

    public function delete(int $id): mixed
    {
        return $this->connector->send(new DeleteInventoryRequest($id))->json();
    }

    public function orderBy(string|null $sort, $direction = null): self
    {
        $this->sort = $sort;
        $this->direction = $direction;

        return $this;
    }

    public function inStock(int $id): mixed
    {
        return $this->update($id, [
            'status' => 'in-stock',
        ]);
    }

    public function sold(int $id): mixed
    {
        return $this->update($id, [
            'status' => 'sold',
        ]);
    }

    public function deposit(int $id): mixed
    {
        return $this->update($id, [
            'status' => 'deposit',
        ]);
    }

    public function active(int $id): mixed
    {
        return $this->update($id, [
            'active' => true,
        ]);
    }

    public function deactivate(int $id): mixed
    {
        return $this->update($id, [
            'active' => false,
        ]);
    }
}
