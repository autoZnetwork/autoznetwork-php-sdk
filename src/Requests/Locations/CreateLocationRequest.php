<?php

namespace AutozNetwork\Requests\Locations;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateLocationRequest extends Request implements HasBody
{
    use HasJsonBody;
    use RequiresEntityID;

    protected Method $method = Method::POST;

    public function __construct(public array $data)
    {
    }

    public function resolveEndpoint(): string
    {
        return '/locations';
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
