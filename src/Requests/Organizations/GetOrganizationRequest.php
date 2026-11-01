<?php

namespace Autoznetwork\AutozNetwork\Requests\Organizations;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetOrganizationRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $params
     */
    public function __construct(
        protected readonly int $id,
        protected readonly array $params = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return "/organizations/$this->id";
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return $this->params;
    }
}
