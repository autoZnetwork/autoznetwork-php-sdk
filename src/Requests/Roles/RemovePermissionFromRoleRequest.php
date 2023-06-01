<?php

namespace AutozNetwork\Requests\Roles;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AcceptsJson;

class RemovePermissionFromRoleRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/roles/$this->roleId/permissions/$this->permissionId";
    }

    public function __construct(
        public int $roleId,
        public int $permissionId,
    ) {
    }
}
