<?php

namespace AutozNetwork\Requests\Notifications;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;
use Saloon\Traits\Plugins\AcceptsJson;

class DeleteNotificationRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;
    use RequiresOrganizationID;

    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/notifications/$this->notificationId";
    }

    public function __construct(public int $notificationId)
    {
    }
}
