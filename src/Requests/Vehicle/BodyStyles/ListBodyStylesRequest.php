<?php

namespace AutozNetwork\Requests\Vehicle\BodyStyles;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListBodyStylesRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function __construct(
        public ?string $sort = null,
        public ?string $direction = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/vehicle/body-styles';
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
