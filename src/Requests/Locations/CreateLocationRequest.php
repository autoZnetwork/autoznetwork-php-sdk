<?php

namespace AutozNetwork\Requests\Locations;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class CreateLocationRequest extends SaloonRequest
{
    use HasJsonBody;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::POST;

    /**
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/locations';
    }

    public function __construct(
        public array $data
    ) {
    }

    public function defaultData(): array
    {
        return $this->data;
    }
}
