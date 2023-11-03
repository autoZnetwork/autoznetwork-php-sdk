<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Categories\GetCategoryRequest;
use AutozNetwork\Requests\Categories\ListCategoriesRequest;

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
