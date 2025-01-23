<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Resources\Vehicle\BodyStyleResource;
use AutozNetwork\Resources\Vehicle\FilterResource;

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
