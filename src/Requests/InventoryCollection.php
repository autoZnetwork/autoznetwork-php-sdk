<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Inventory\CreateInventoryRequest;
use AutozNetwork\Requests\Inventory\DeleteInventoryRequest;
use AutozNetwork\Requests\Inventory\GetInventoryFacetsRequest;
use AutozNetwork\Requests\Inventory\GetInventoryRequest;
use AutozNetwork\Requests\Inventory\ListInventoryRequest;
use AutozNetwork\Requests\Inventory\SearchInventoryRequest;
use AutozNetwork\Requests\Inventory\UpdateInventoryRequest;

class InventoryCollection extends BaseCollection
{
    protected bool $cache = true;

    public function withoutCache(): self
    {
        $this->cache = false;

        return $this;
    }

    public function search($params = [], $searchTerm = null)
    {
        return $this->send(
            $this->connector->request(new SearchInventoryRequest($params, $searchTerm))
        );
    }

    public function facets($params = [])
    {
        return $this->send(
            $this->connector->request(new GetInventoryFacetsRequest($params))
        );
    }

    public function all($params = [])
    {
        return $this->send(
            $this->connector->request(new ListInventoryRequest($params))
        );
    }

    public function get(int $inventoryId, $params = [])
    {
        return $this->send(
            $this->connector->request(new GetInventoryRequest($inventoryId, $params, $this->cache))
        );
    }

    public function create(array $data)
    {
        return $this->send(
            $this->connector->request(new CreateInventoryRequest($data))
        );
    }

    public function update(int $inventoryId, array $data)
    {
        return $this->send(
            $this->connector->request(new UpdateInventoryRequest($inventoryId, $data))
        );
    }

    public function delete(int $inventoryId)
    {
        return $this->send(
            $this->connector->request(new DeleteInventoryRequest($inventoryId))
        );
    }

    public function inStock(int $inventoryId)
    {
        return $this->update($inventoryId, [
            'status' => 'in-stock',
        ]);
    }

    public function sold(int $inventoryId)
    {
        return $this->update($inventoryId, [
            'status' => 'sold',
        ]);
    }

    public function deposit(int $inventoryId)
    {
        return $this->update($inventoryId, [
            'status' => 'deposit',
        ]);
    }

    public function active(int $inventoryId)
    {
        return $this->update($inventoryId, [
            'active' => true,
        ]);
    }

    public function deactivate(int $inventoryId)
    {
        return $this->update($inventoryId, [
            'active' => false,
        ]);
    }
}
