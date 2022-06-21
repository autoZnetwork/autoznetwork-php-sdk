<?php

namespace AutozNetwork\AutozNetwork\Requests\Example;

use AutozNetwork\AutozNetwork\Requests\Request;
use Sammyjo20\Saloon\Constants\Saloon;

class ExampleRequest extends Request
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
        return '/';
    }
}
