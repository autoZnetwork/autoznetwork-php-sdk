<?php

namespace Autoznetwork\AutozNetwork\Requests\Organizations;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Replace the organization's search banners (the endpoint keeps its historical name).
 */
class UpdateBannersRequest extends Request implements HasBody
{
    use HasJsonBody;
    use RequiresEntityId;

    protected Method $method = Method::POST;

    /**
     * @param  array<int, array<string, mixed>>  $banners
     */
    public function __construct(
        protected readonly array $banners,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizations/algolia-banners';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [
            'banners' => $this->banners,
        ];
    }
}
