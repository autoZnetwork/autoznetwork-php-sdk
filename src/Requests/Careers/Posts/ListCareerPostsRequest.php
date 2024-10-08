<?php

namespace AutozNetwork\Requests\Careers\Posts;

use AutozNetwork\Traits\RequiresEntityID;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListCareerPostsRequest extends Request
{
    use RequiresEntityID;

    protected Method $method = Method::GET;

    public function __construct(
        public array $params,
        public ?string $sort = null,
        public ?string $direction = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/careers/posts';
    }

    protected function defaultFilters(): array
    {
        return [
            'filter' => [
                'active' => true,
                'listing.active' => true,
            ],
        ];
    }

    public function defaultQuery(): array
    {
        if ($this->sort) {
            $this->params['sort'] = $this->sort;

            if ($this->direction) {
                $this->params['sort_direction'] = $this->direction;
            }
        }

        return [
            ...$this->params,
            ...$this->defaultFilters(),
        ];
    }
}
