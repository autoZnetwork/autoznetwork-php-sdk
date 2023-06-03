<?php

namespace AutozNetwork\Requests\Roles;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class RemovePermissionFromRoleRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function __construct(
        public int $roleId,
        public int $permissionId,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return "/roles/$this->roleId/permissions/$this->permissionId";
    }
}
