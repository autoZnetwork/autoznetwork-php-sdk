<?php

namespace AutozNetwork\Requests\Notifications;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListNotificationsRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/notifications';
    }
}
