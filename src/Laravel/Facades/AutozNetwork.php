<?php

namespace Autoznetwork\AutozNetwork\Laravel\Facades;

use Autoznetwork\AutozNetwork\AutozNetwork as Client;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Client withOrganization(int|string|null $organizationId)
 * @method static Client withEnterprise(int|string|null $enterpriseId)
 * @method static Client withEntity(\Autoznetwork\AutozNetwork\Enums\EntityType $type, int|string $id)
 * @method static \Autoznetwork\AutozNetwork\Resources\CareerResource careers()
 * @method static \Autoznetwork\AutozNetwork\Resources\CategoryResource categories()
 * @method static \Autoznetwork\AutozNetwork\Resources\EnterpriseResource enterprises()
 * @method static \Autoznetwork\AutozNetwork\Resources\FeedResource feeds()
 * @method static \Autoznetwork\AutozNetwork\Resources\InventoryResource inventory()
 * @method static \Autoznetwork\AutozNetwork\Resources\LocationResource locations()
 * @method static \Autoznetwork\AutozNetwork\Resources\OrganizationResource organizations()
 * @method static \Autoznetwork\AutozNetwork\Resources\SyndicationResource syndications()
 * @method static \Autoznetwork\AutozNetwork\Resources\UserResource users()
 * @method static \Autoznetwork\AutozNetwork\Resources\VehicleResource vehicle()
 *
 * @see Client
 */
final class AutozNetwork extends Facade
{
    /**
     * Resolve a fresh client on every call. The connector is bound, not
     * shared, and a cached facade instance would pin one request's
     * credentials for the life of an Octane worker.
     *
     * @var bool
     */
    protected static $cached = false;

    protected static function getFacadeAccessor(): string
    {
        return Client::class;
    }
}
