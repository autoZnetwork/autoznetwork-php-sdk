<?php

namespace AutozNetwork\Requests;

use AutozNetwork\AutozNetwork;
use Sammyjo20\Saloon\Http\SaloonRequest;

class Request extends SaloonRequest
{
    /**
     * @var string|null
     */
    protected ?string $connector = AutozNetwork::class;
}
