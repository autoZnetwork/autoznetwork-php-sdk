<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Inventory\CreateInventoryRequest;
use AutozNetwork\Requests\Inventory\DeleteInventoryRequest;
use AutozNetwork\Requests\Inventory\GetInventoryFacetsRequest;
use AutozNetwork\Requests\Inventory\GetInventoryRequest;
use AutozNetwork\Requests\Inventory\ListInventoryRequest;
use AutozNetwork\Requests\Inventory\SearchInventoryRequest;
use AutozNetwork\Requests\Inventory\UpdateInventoryRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class InventoryCollection extends RequestCollection
{
    public function search($filters = [], $params = [])
    {
        $request = $this->connector->request(new SearchInventoryRequest($filters, $params));
        $response = $request->send();

        return $response->json();
    }

    public function facets($params = [])
    {
        $request = $this->connector->request(new GetInventoryFacetsRequest($params));
        $response = $request->send();

        return $response->json();
    }

    public function all($filters = [], $params = [])
    {
        $request = $this->connector->request(new ListInventoryRequest($filters, $params));
        $response = $request->send();

        return $response->json();
    }

    public function get(int $inventoryId, $params = [])
    {
        $request = $this->connector->request(new GetInventoryRequest($inventoryId, $params));
        $response = $request->send();

        return $response->json();
    }

    public function create(array $data)
    {
        $request = $this->connector->request(new CreateInventoryRequest($data));
        $response = $request->send();

        return $response->json();
    }

    public function update(int $inventoryId, array $data)
    {
        $request = $this->connector->request(new UpdateInventoryRequest($inventoryId, $data));
        $response = $request->send();

        return $response->json();
    }

    public function delete(int $inventoryId)
    {
        $request = $this->connector->request(new DeleteInventoryRequest($inventoryId));
        $response = $request->send();

        return $response->json();
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
