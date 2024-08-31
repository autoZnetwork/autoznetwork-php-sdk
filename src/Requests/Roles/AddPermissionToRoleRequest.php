<?php

namespace AutozNetwork\Requests\Roles;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class AddPermissionToRoleRequest extends Request
{
    protected Method $method = Method::POST;

    public function __construct(
        public int $roleId,
        public int $permissionId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/roles/$this->roleId/permissions/$this->permissionId";
    }
}
