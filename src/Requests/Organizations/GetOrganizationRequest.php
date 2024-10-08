<?php

namespace AutozNetwork\Requests\Organizations;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetOrganizationRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $id, public array $params = []) {}

    public function resolveEndpoint(): string
    {
        return "/organizations/$this->id";
    }

    public function defaultQuery(): array
    {
        return $this->params;
    }
}
