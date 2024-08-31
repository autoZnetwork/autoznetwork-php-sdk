<?php

namespace AutozNetwork\Resources;

use Saloon\Http\Connector;

abstract class BaseResource
{
    protected ?string $sort = null;

    protected ?string $direction = null;

    public function __construct(protected Connector $connector) {}

    public function orderBy(?string $sort, $direction = null): self
    {
        $this->sort = $sort;
        $this->direction = $direction;

        return $this;
    }
}
