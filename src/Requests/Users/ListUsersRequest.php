<?php

namespace AutozNetwork\Requests\Users;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListUsersRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/users';
    }
}
