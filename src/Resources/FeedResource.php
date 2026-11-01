<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Autoznetwork\AutozNetwork\Requests\Feeds\ListFeedsRequest;

class FeedResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListFeedsRequest)->json();
    }
}
