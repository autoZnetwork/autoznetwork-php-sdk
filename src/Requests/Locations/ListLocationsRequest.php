<?php

namespace AutozNetwork\Requests\Locations;

use AutozNetwork\Requests\Request;
use Sammyjo20\Saloon\Constants\Saloon;

class ListLocationsRequest extends Request
{
    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::GET;

    /**
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/locations';
    }
}
