<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Autoznetwork\AutozNetwork\Requests\Categories\GetCategoryRequest;
use Autoznetwork\AutozNetwork\Requests\Categories\ListCategoriesRequest;

/**
 * Vehicle categories (car, truck, RV, ...), as `/vehicle/categories`.
 */
class CategoryResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListCategoriesRequest(
            sort: $this->sort,
            direction: $this->direction,
        ))->json();
    }

    public function get(int|string $idOrSlug): mixed
    {
        return $this->connector->send(new GetCategoryRequest($idOrSlug))->json();
    }
}
