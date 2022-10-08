<?php

namespace AutozNetwork\Requests\Syndications;

use AutozNetwork\Traits\RequiresOrganizationID;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class CreateSyndicationRequest extends SaloonRequest
{
    use HasJsonBody;
    use AcceptsJson;
    use RequiresOrganizationID;

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
        return '/syndications';
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
