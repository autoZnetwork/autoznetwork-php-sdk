<?php

namespace Autoznetwork\AutozNetwork\Requests\Careers\Posts;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Job posts that are active and listed, for careers pages.
 */
class ListCareerPostsRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $params
     */
    public function __construct(
        protected readonly array $params = [],
        protected readonly ?string $sort = null,
        protected readonly ?string $direction = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/careers/posts';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        $query = $this->params;

        if ($this->sort !== null) {
            $query['sort'] = $this->sort;

            if ($this->direction !== null) {
                $query['sort_direction'] = $this->direction;
            }
        }

        $query['filter'] = [
            'active' => true,
            'listing.active' => true,
            ...($query['filter'] ?? []),
        ];

        return $query;
    }
}
