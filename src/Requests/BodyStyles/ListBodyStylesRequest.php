<?php

namespace AutozNetwork\Requests\BodyStyles;

use AutozNetwork\Traits\RequiresOrganizationID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListBodyStylesRequest extends Request
{
    use RequiresOrganizationID;

    protected Method $method = Method::GET;

    public function __construct(
        public ?string $sort = null,
        public ?string $direction = null,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/vehicles/body-styles';
    }

    public function defaultQuery(): array
    {
        $returnArr = [];

        if ($this->sort) {
            $returnArr['sort'] = $this->sort;

            if ($this->direction) {
                $returnArr['sort_direction'] = $this->direction;
            }
        }

        return $returnArr;
    }
}
