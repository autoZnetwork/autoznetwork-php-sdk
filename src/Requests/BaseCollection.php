<?php

namespace AutozNetwork\Requests;

use Sammyjo20\Saloon\Http\RequestCollection;
use Sammyjo20\Saloon\Http\SaloonRequest;

abstract class BaseCollection extends RequestCollection
{
    protected function send(SaloonRequest $connector): mixed
    {
        return $connector->send()->json();
    }
}
