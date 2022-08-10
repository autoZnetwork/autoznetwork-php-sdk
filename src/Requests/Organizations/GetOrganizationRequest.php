<?php

namespace AutozNetwork\Requests\Organizations;

use AutozNetwork\Requests\Request;
use Sammyjo20\Saloon\Constants\Saloon;

class GetOrganizationRequest extends Request
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
        return '/organizations/'.$this->organizationId;
    }

    public function __construct(
        public int $organizationId
    ) {
    }
}
