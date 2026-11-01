<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Autoznetwork\AutozNetwork\Requests\Inventory\AuditInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\CreateInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\DeleteInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\GetInventoryFacetsRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\GetInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\GetRelatedInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\ListInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\SearchInventoryRequest;
use Autoznetwork\AutozNetwork\Requests\Inventory\UpdateInventoryRequest;

/**
 * Vehicles in an organization's or enterprise's inventory.
 */
class InventoryResource extends BaseResource
{
    /**
     * Query parameters that make a list call return a vehicle whatever became
     * of it. Unless told otherwise the inventory API returns only vehicles
     * that are active, marketable, retail and in stock, which hides exactly
     * the sold vehicle a lead or a badge needs to know about. Appraisals stay
     * out: they are not for sale.
     *
     * @var array<string, string>
     */
    public const array ANY_VEHICLE_FILTERS = [
        'filter[active]' => '1,0',
        'filter[marketable]' => '1,0',
        'filter[status]' => 'retail,wholesale',
        'filter[stock_status]' => 'all',
    ];

    protected bool $cache = true;

    /**
     * @param  array<string, mixed>  $params
     */
    public function all(array $params = []): mixed
    {
        return $this->connector->send(new ListInventoryRequest(
            params: $this->formatParams($params),
            sort: $this->sort,
            direction: $this->direction,
        ))->json();
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public function get(int $id, array $params = []): mixed
    {
        return $this->connector->send(new GetInventoryRequest($id, $params, $this->cache))->json();
    }

    /**
     * The first vehicle with this stock number, or null.
     *
     * @param  bool|null  $online  true: in stock only, false: out of stock only, null: either
     */
    public function getByStock(string $stock, ?bool $online = null): mixed
    {
        return $this->firstMatching(['stock' => $stock], $online);
    }

    /**
     * The first vehicle with this VIN, or null.
     */
    public function getByVin(string $vin, ?bool $online = null): mixed
    {
        return $this->firstMatching(['vin' => $vin], $online);
    }

    /**
     * The first vehicle with both this stock number and this VIN, or null.
     */
    public function getByStockAndVin(string $stock, string $vin, ?bool $online = null): mixed
    {
        return $this->firstMatching(['stock' => $stock, 'vin' => $vin], $online);
    }

    /**
     * One vehicle, sold or not, by stock number, or by VIN when there is no
     * stock number or inventory does not know it. Null when neither finds
     * exactly one.
     *
     * @param  array<string, mixed>  $params  added to each request, e.g. `include`
     * @return array<string, mixed>|null
     */
    public function findByStockOrVin(?string $stock, ?string $vin, array $params = []): ?array
    {
        foreach (['stock' => $stock, 'vin' => $vin] as $field => $value) {
            if ($value === null || trim($value) === '') {
                continue;
            }

            $vehicles = $this->all([
                ...$params,
                ...self::ANY_VEHICLE_FILTERS,
                'limit' => 1,
                "filter[$field]" => $value,
            ])['data'] ?? [];

            if (count($vehicles) === 1) {
                return $vehicles[0];
            }
        }

        return null;
    }

    public function related(int $id, int $limit = 4): mixed
    {
        return $this->connector->send(new GetRelatedInventoryRequest($id, $limit))->json();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): mixed
    {
        return $this->connector->send(new CreateInventoryRequest($data))->json();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): mixed
    {
        return $this->connector->send(new UpdateInventoryRequest($id, $data))->json();
    }

    public function delete(int $id): mixed
    {
        return $this->connector->send(new DeleteInventoryRequest($id))->json();
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public function search(array $params = [], ?string $searchTerm = null): mixed
    {
        return $this->connector->send(new SearchInventoryRequest(
            params: $this->formatParams($params),
            searchTerm: $searchTerm,
            sort: $this->sort,
            direction: $this->direction,
        ))->json();
    }

    /**
     * @param  array<int, array<string, mixed>>  $vehicles
     */
    public function audit(array $vehicles): mixed
    {
        return $this->connector->send(new AuditInventoryRequest($vehicles))->json();
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public function facets(array $params = []): mixed
    {
        return $this->connector->send(new GetInventoryFacetsRequest($params))->json();
    }

    /**
     * Ask the API for a fresh copy on the next `get()`.
     */
    public function withoutCache(): static
    {
        $this->cache = false;

        return $this;
    }

    public function activate(int $id): mixed
    {
        return $this->update($id, ['active' => true]);
    }

    public function deactivate(int $id): mixed
    {
        return $this->update($id, ['active' => false]);
    }

    /**
     * @param  array<string, string>  $filter
     */
    private function firstMatching(array $filter, ?bool $online): mixed
    {
        $this->filter = $filter;

        $result = $this->all([
            'stock_status' => match ($online) {
                null => '1,0',
                true => '1',
                false => '0',
            },
            'limit' => 1,
        ]);

        return $result['data'][0] ?? null;
    }
}
