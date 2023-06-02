<?php

namespace AutozNetwork\Requests\Syndications;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AcceptsJson;

class CreateSyndicationRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/syndications';
    }

    public function __construct(public array $data)
    {
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
