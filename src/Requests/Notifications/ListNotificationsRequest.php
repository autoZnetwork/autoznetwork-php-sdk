<?php

namespace AutozNetwork\Requests\Notifications;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListNotificationsRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/notifications';
    }
}
