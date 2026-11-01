<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Autoznetwork\AutozNetwork\Resources\Careers\CareerPostResource;

class CareerResource extends BaseResource
{
    public function posts(): CareerPostResource
    {
        return new CareerPostResource($this->connector);
    }
}
