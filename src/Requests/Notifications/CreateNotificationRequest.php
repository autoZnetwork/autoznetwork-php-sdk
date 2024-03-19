<?php

namespace AutozNetwork\Requests\Notifications;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateNotificationRequest extends Request implements HasBody
{
    use HasJsonBody;
    use RequiresEntityID;

    protected Method $method = Method::POST;

    public function __construct(public array $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/notifications';
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
