<?php

namespace AutozNetwork\Requests\Users;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetUserRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/users/$this->id";
    }
}
