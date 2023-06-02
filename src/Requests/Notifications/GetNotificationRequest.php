<?php

namespace AutozNetwork\Requests\Notifications;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\AcceptsJson;

class GetNotificationRequest extends Request
{
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/notifications/$this->notificationId";
    }

    public function __construct(public int $notificationId)
    {
    }
}
