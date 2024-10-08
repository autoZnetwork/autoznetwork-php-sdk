<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Resources\Careers\CareerPostResource;

class CareerResource extends BaseResource
{
    public function posts(): CareerPostResource
    {
        return new CareerPostResource($this->connector);
    }
}
