<?php

namespace AutozNetwork\Requests\Permissions;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetPermissionRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public int $id) {}

    public function resolveEndpoint(): string
    {
        return "/permissions/$this->id";
    }
}
