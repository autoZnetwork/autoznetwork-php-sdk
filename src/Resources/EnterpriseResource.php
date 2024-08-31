<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Enterprises\GetEnterpriseRequest;
use AutozNetwork\Requests\Enterprises\ListEnterprisesRequest;

class EnterpriseResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListEnterprisesRequest)->json();
    }

    public function get(int $id, array $params = []): mixed
    {
        return $this->connector->send(new GetEnterpriseRequest($id, $params))->json();
    }
}
