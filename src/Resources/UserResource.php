<?php

namespace Autoznetwork\AutozNetwork\Resources;

use Autoznetwork\AutozNetwork\Requests\Users\GetUserByEmailRequest;
use Autoznetwork\AutozNetwork\Requests\Users\GetUserRequest;
use Autoznetwork\AutozNetwork\Requests\Users\ListUsersRequest;

class UserResource extends BaseResource
{
    /**
     * @param  array<string, mixed>  $params
     */
    public function all(array $params = []): mixed
    {
        return $this->connector->send(new ListUsersRequest($this->formatParams($params)))->json();
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public function get(int $id, array $params = []): mixed
    {
        return $this->connector->send(new GetUserRequest($id, $this->formatParams($params)))->json();
    }

    /**
     * @param  array<string, mixed>  $params
     */
    public function getByEmail(string $email, array $params = []): mixed
    {
        return $this->connector->send(new GetUserByEmailRequest($email, $this->formatParams($params)))->json();
    }
}
