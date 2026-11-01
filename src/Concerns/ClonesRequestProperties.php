<?php

namespace Autoznetwork\AutozNetwork\Concerns;

/**
 * Makes `clone $connector` safe.
 *
 * Saloon keeps headers, query, config, middleware and delay in lazily created
 * store objects on the connector. A shallow clone would share them, so a
 * header added on the copy would appear on the original. The mock client is
 * deliberately shared so tests can scope a mocked client with `with*()`.
 */
trait ClonesRequestProperties
{
    public function __clone(): void
    {
        if (isset($this->headers)) {
            $this->headers = clone $this->headers;
        }

        if (isset($this->query)) {
            $this->query = clone $this->query;
        }

        if (isset($this->config)) {
            $this->config = clone $this->config;
        }

        if (isset($this->middlewarePipeline)) {
            $this->middlewarePipeline = clone $this->middlewarePipeline;
        }

        if (isset($this->delay)) {
            $this->delay = clone $this->delay;
        }
    }
}
