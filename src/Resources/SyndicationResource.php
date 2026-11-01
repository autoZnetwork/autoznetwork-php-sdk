<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Autoznetwork\AutozNetwork\Requests\Syndications\ListSyndicationsRequest;

class SyndicationResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListSyndicationsRequest)->json();
    }
}
