<?php

namespace AutozNetwork\Requests\Enterprises;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetEnterpriseRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $id, public array $params = []) {}

    public function resolveEndpoint(): string
    {
        return "/enterprises/$this->id";
    }

    public function defaultQuery(): array
    {
        return $this->params;
    }
}
