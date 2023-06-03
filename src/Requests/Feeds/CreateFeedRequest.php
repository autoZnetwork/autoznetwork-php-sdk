<?php

namespace AutozNetwork\Requests\Feeds;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateFeedRequest extends Request implements HasBody
{
    use HasJsonBody;
    use RequiresOrganizationID;

    protected Method $method = Method::POST;

    public function __construct(public array $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/feeds';
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
