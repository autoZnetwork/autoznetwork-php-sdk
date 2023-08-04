<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Inventory\AuditInventoryRequest;
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

    protected array $filter = [];

    protected array $exclude = [];

    public function withoutCache(): self
    {
        $this->cache = false;

        return $this;
    }

    public function filter(array $data): self
    {
        $this->filter = $data;

        return $this;
    }

    public function exclude(array $data): self
    {
        $this->exclude = $data;

        return $this;
    }

    public function all(array $params = []): mixed
    {
        if (count($this->filter) > 0) {
            $params['filter'] = $this->filter;
        }

        if (count($this->exclude) > 0) {
            $params['exclude'] = $this->exclude;
        }

        return $this->connector->send(
            new ListInventoryRequest($params, $this->sort, $this->direction)
        )->json();
    }

    public function get(int $id, array $params = []): mixed
    {
        return $this->connector->send(new GetInventoryRequest($id, $params, $this->cache))->json();
    }

    public function getByStockAndVin(string $stock, string $vin): mixed
    {
        $this->filter = [
            'stock' => $stock,
            'vin' => $vin,
            'active' => '1,0',
        ];

        $query = $this->all([
            'sold_at' => '1,0',
            'limit' => 1,
        ]);

        return $query['data'][0] ?? null;
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

    public function search(array $params = [], string $searchTerm = null): mixed
    {
        return $this->connector->send(
            new SearchInventoryRequest($params, $searchTerm, $this->sort, $this->direction)
        )->json();
    }

    public function audit(array $vehicles): mixed
    {
        return $this->connector->send(new AuditInventoryRequest($vehicles))->json();
    }

    public function facets($params = []): mixed
    {
        return $this->connector->send(new GetInventoryFacetsRequest($params))->json();
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
