<?php

namespace AutozNetwork\Requests\Roles;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class GetRoleRequest extends Request
{
    use AcceptsJson;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/roles/$this->roleId";
    }

    public function __construct(public int $roleId)
    {
    }
}
