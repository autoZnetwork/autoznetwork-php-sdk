<?php

namespace Autoznetwork\AutozNetwork\Requests\Categories;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetCategoryRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    public function __construct(
        protected readonly int|string $idOrSlug,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/vehicle/categories/$this->idOrSlug";
    }
}
