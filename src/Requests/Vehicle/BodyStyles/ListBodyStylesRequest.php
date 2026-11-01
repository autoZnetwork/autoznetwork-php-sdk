<?php

namespace Autoznetwork\AutozNetwork\Requests\Vehicle\BodyStyles;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListBodyStylesRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    public function __construct(
        protected readonly ?string $sort = null,
        protected readonly ?string $direction = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/vehicle/body-styles';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        $query = [];

        if ($this->sort !== null) {
            $query['sort'] = $this->sort;

            if ($this->direction !== null) {
                $query['sort_direction'] = $this->direction;
            }
        }

        return $query;
    }
}
