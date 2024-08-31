<?php

namespace AutozNetwork\Requests\Syndications;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetSyndicationRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function __construct(public int $id) {}

    public function resolveEndpoint(): string
    {
        return "/syndications/$this->id";
    }
}
