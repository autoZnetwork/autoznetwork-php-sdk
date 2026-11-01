<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Autoznetwork\AutozNetwork\Resources\Vehicle\BodyStyleResource;
use Autoznetwork\AutozNetwork\Resources\Vehicle\FilterResource;

/**
 * Reference data about vehicles: body styles and search filters.
 */
class VehicleResource extends BaseResource
{
    public function bodyStyles(): BodyStyleResource
    {
        return new BodyStyleResource($this->connector);
    }

    public function filters(): FilterResource
    {
        return new FilterResource($this->connector);
    }
}
