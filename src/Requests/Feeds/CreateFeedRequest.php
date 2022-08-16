<?php

namespace AutozNetwork\Requests\Feeds;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class CreateFeedRequest extends SaloonRequest
{
    use HasJsonBody;
    use AcceptsJson;

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
        return '/feeds';
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
