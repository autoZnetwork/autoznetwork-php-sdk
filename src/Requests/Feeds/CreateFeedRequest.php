<?php

namespace AutozNetwork\Requests\Feeds;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AcceptsJson;

class CreateFeedRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/feeds';
    }

    public function __construct(public array $data)
    {
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
