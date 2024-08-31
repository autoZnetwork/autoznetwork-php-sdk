<?php

namespace AutozNetwork\Requests\Categories;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCategoryRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function __construct(public int|string $idOrSlug) {}

    public function resolveEndpoint(): string
    {
        return "/vehicle/categories/$this->idOrSlug";
    }
}
