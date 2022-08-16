<?php

namespace AutozNetwork\Requests\Syndications;

use AutozNetwork\Requests\Request;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;

class GetSyndicationRequest extends Request
{
    use AcceptsJson;
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
        return '/syndications/'.$this->syndicationId;
    }

    public function __construct(
        public int $syndicationId
    ) {
    }
}
