<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Saloon\Http\Connector;

/**
 * A resource is cheap and short-lived: the connector hands out a new one per
 * call, so the fluent `filter()` / `with()` / `orderBy()` state never leaks
 * between calls.
 */
abstract class BaseResource
{
    /**
     * @var array<string, mixed>
     */
    protected array $filter = [];

    /**
     * @var array<string, mixed>
     */
    protected array $exclude = [];

    /**
     * @var list<string>
     */
    protected array $with = [];

    protected ?string $sort = null;

    protected ?string $direction = null;

    public function __construct(protected Connector $connector) {}

    /**
     * `filter[key]=value` query parameters.
     *
     * @param  array<string, mixed>  $filter
     */
    public function filter(array $filter): static
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * `exclude[key]=value` query parameters.
     *
     * @param  array<string, mixed>  $exclude
     */
    public function exclude(array $exclude): static
    {
        $this->exclude = $exclude;

        return $this;
    }

    /**
     * Relationships to include, sent as a comma-separated `include`.
     *
     * @param  list<string>  $with
     */
    public function with(array $with): static
    {
        $this->with = $with;

        return $this;
    }

    public function orderBy(?string $sort, ?string $direction = null): static
    {
        $this->sort = $sort;
        $this->direction = $direction;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $params
     * @return array<string, mixed>
     */
    protected function formatParams(array $params = []): array
    {
        if ($this->filter !== []) {
            $params['filter'] = $this->filter;
        }

        if ($this->exclude !== []) {
            $params['exclude'] = $this->exclude;
        }

        if ($this->with !== []) {
            $params['include'] = implode(',', $this->with);
        }

        return $params;
    }
}
