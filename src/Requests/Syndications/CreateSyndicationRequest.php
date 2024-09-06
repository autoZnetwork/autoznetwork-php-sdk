<?php

namespace AutozNetwork\Requests\Syndications;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateSyndicationRequest extends Request implements HasBody
{
    use HasJsonBody;
    use RequiresEntityID;

    protected Method $method = Method::POST;

    public function __construct(public array $data) {}

    public function resolveEndpoint(): string
    {
        return '/syndications';
    }

    public function defaultBody(): array
    {
        return $this->data;
    }
}
