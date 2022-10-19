<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Inventory\CreateInventoryImageRequest;
use AutozNetwork\Requests\Inventory\CreateInventoryRequest;
use AutozNetwork\Requests\Inventory\DeleteInventoryRequest;
use AutozNetwork\Requests\Inventory\GetInventoryRequest;
use AutozNetwork\Requests\Inventory\SearchInventoryRequest;
use AutozNetwork\Requests\Inventory\UpdateInventoryRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class InventoryCollection extends RequestCollection
{
    public function search($filters = [])
    {
        $request = $this->connector->request(new SearchInventoryRequest($filters));
        $response = $request->send();

        return $response->json();
    }

    public function all($filters = [])
    {
        $request = $this->connector->request(new CreateInventoryImageRequest($filters));
        $response = $request->send();

        return $response->json();
    }

    public function get(int $inventoryId)
    {
        $request = $this->connector->request(new GetInventoryRequest($inventoryId));
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

    public function inStock(int $inventorId)
    {
        return $this->update($inventorId, [
            'status' => 'in-stock',
        ]);
    }

    public function sold(int $inventorId)
    {
        return $this->update($inventorId, [
            'status' => 'sold',
        ]);
    }

    public function deposit(int $inventorId)
    {
        return $this->update($inventorId, [
            'status' => 'deposit',
        ]);
    }

    public function active(int $inventorId)
    {
        return $this->update($inventorId, [
            'active' => true,
        ]);
    }

    public function deactivate(int $inventorId)
    {
        return $this->update($inventorId, [
            'active' => false,
        ]);
    }
}
