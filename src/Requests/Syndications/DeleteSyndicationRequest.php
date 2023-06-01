<?php

namespace AutozNetwork\Requests\Syndications;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AcceptsJson;

class DeleteSyndicationRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/syndications/'.$this->syndicationId;
    }

    public function __construct(public int $syndicationId)
    {
    }
}
