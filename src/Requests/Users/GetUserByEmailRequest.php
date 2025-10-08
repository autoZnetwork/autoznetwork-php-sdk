<?php

namespace AutozNetwork\Requests\Users;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetUserByEmailRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function __construct(public string $email, public array $params) {}

    public function resolveEndpoint(): string
    {
        return '/users/email';
    }

    public function defaultQuery(): array
    {
        return [
            ...$this->params,
            ...[
                'email' => $this->email,
            ],
        ];
    }
}
