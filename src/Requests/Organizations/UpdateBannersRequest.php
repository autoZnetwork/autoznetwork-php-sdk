<?php

namespace AutozNetwork\Requests\Organizations;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class UpdateBannersRequest extends Request implements HasBody
{
    use HasJsonBody;
    use RequiresOrganizationID;

    protected Method $method = Method::POST;

    public function __construct(public array $banners)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/organizations/algolia-banners';
    }

    public function defaultBody(): array
    {
        return [
            'banners' => $this->banners,
        ];
    }
}
