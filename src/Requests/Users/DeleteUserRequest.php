<?php

namespace AutozNetwork\Requests\Users;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AcceptsJson;

class DeleteUserRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/users/$this->userId";
    }

    public function __construct(public int $userId)
    {
    }
}
