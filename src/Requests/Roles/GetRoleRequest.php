<?php

namespace AutozNetwork\Requests\Roles;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRoleRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $id) {}

    public function resolveEndpoint(): string
    {
        return "/roles/$this->id";
    }
}
