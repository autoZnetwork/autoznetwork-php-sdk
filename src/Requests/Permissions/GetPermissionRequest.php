<?php

namespace AutozNetwork\Requests\Permissions;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class GetPermissionRequest extends Request
{
    use AcceptsJson;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/permissions/$this->permissionId";
    }

    public function __construct(public int $permissionId)
    {
    }
}
