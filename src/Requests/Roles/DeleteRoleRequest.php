<?php

namespace AutozNetwork\Requests\Roles;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteRoleRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(public int $id) {}

    public function resolveEndpoint(): string
    {
        return "/roles/$this->id";
    }
}
