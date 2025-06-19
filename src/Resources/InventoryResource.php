<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Inventory\AuditInventoryRequest;
use AutozNetwork\Requests\Inventory\CreateInventoryRequest;
use AutozNetwork\Requests\Inventory\DeleteInventoryRequest;
use AutozNetwork\Requests\Inventory\GetInventoryFacetsRequest;
use AutozNetwork\Requests\Inventory\GetInventoryRequest;
use AutozNetwork\Requests\Inventory\GetRelatedInventoryRequest;
use AutozNetwork\Requests\Inventory\ListInventoryRequest;
use AutozNetwork\Requests\Inventory\SearchInventoryRequest;
use AutozNetwork\Requests\Inventory\UpdateInventoryRequest;

class InventoryResource extends BaseResource
{
    protected bool $cache = true;

    public function all(array $params = []): mixed
    {
        return $this->connector->send(new ListInventoryRequest(
            params: $this->formatParams($params),
            sort: $this->sort,
            direction: $this->direction,
        ))->json();
    }

    public function get(int $id, array $params = []): mixed
    {
        return $this->connector->send(new GetInventoryRequest($id, $params, $this->cache))->json();
    }

    public function getByStock(string $stock, ?bool $online = null): mixed
    {
        $this->filter = [
            'stock' => $stock,
        ];

        $online = match ($online) {
            null => '1,0',
            true => '1',
            false => '0',
        };

        $query = $this->all([
            'stock_status' => $online,
            'limit' => 1,
        ]);

        return $query['data'][0] ?? null;
    }

    public function getByVin(string $vin, ?bool $online = null): mixed
    {
        $this->filter = [
            'vin' => $vin,
        ];

        $online = match ($online) {
            null => '1,0',
            true => '1',
            false => '0',
        };

        $query = $this->all([
            'stock_status' => $online,
            'limit' => 1,
        ]);

        return $query['data'][0] ?? null;
    }

    public function getByStockAndVin(string $stock, string $vin, ?bool $online = null): mixed
    {
        $this->filter = [
            'stock' => $stock,
            'vin' => $vin,
        ];

        $online = match ($online) {
            null => '1,0',
            true => '1',
            false => '0',
        };

        $query = $this->all([
            'stock_status' => $online,
            'limit' => 1,
        ]);

        return $query['data'][0] ?? null;
    }

    public function related(int $id, int $limit = 4): mixed
    {
        return $this->connector->send(new GetRelatedInventoryRequest($id, $limit))->json();
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

    public function search(array $params = [], ?string $searchTerm = null): mixed
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

    public function with(array $data): self
    {
        $this->with = $data;

        return $this;
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
