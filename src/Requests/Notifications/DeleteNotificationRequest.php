<?php

namespace AutozNetwork\Requests\Notifications;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class DeleteNotificationRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::DELETE;

    public function __construct(public int $id)
    {
    }

    public function resolveEndpoint(): string
    {
        return "/notifications/$this->id";
    }
}
