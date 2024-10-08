<?php

namespace AutozNetwork\Resources;

use Saloon\Http\Connector;

abstract class BaseResource
{
    protected array $filter = [];

    protected array $exclude = [];

    protected array $with = [];

    protected ?string $sort = null;

    protected ?string $direction = null;

    public function __construct(protected Connector $connector) {}

    public function orderBy(?string $sort, $direction = null): self
    {
        $this->sort = $sort;
        $this->direction = $direction;

        return $this;
    }

    protected function formatParams(array $params = []): array
    {
        if (count($this->filter) > 0) {
            $params['filter'] = $this->filter;
        }

        if (count($this->exclude) > 0) {
            $params['exclude'] = $this->exclude;
        }

        if (count($this->with) > 0) {
            $params['include'] = implode(',', $this->with);
        }

        return $params;
    }
}
