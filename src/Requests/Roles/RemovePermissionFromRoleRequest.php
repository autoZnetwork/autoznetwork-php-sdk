<?php

namespace AutozNetwork\Requests\Roles;

use AutozNetwork\Requests\Request;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class RemovePermissionFromRoleRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::DELETE;

    /**
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/roles/'.$this->roleId.'/permissions/'.$this->permissionId;
    }

    public function __construct(
        public int $roleId,
        public int $permissionId
    ) {
    }
}
