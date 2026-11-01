<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Autoznetwork\AutozNetwork\Requests\Enterprises\GetEnterpriseRequest;
use Autoznetwork\AutozNetwork\Requests\Enterprises\ListEnterprisesRequest;

/**
 * Dealership groups. Both calls work unscoped.
 */
class EnterpriseResource extends BaseResource
{
    public function all(): mixed
    {
        return $this->connector->send(new ListEnterprisesRequest)->json();
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public function get(int $id, array $params = []): mixed
    {
        return $this->connector->send(new GetEnterpriseRequest($id, $this->formatParams($params)))->json();
    }
}
