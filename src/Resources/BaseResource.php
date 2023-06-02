<?php

namespace AutozNetwork\Resources;

use Saloon\Contracts\Connector;

abstract class BaseResource
{
    public function __construct(protected Connector $connector)
    {
    }
}
