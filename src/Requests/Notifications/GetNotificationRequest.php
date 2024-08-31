<?php

namespace AutozNetwork\Requests\Notifications;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetNotificationRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function __construct(public int $id) {}

    public function resolveEndpoint(): string
    {
        return "/notifications/$this->id";
    }
}
