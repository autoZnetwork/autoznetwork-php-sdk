<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Users\DeleteUserRequest;
use AutozNetwork\Requests\Users\GetUserRequest;
use AutozNetwork\Requests\Users\ListUsersRequest;

class UserResource extends BaseResource
{
    public function all(array $params = []): mixed
    {
        return $this->connector->send(new ListUsersRequest($params))->json();
    }

    public function get(int $id): mixed
    {
        return $this->connector->send(new GetUserRequest($id))->json();
    }

    public function delete(int $id): mixed
    {
        return $this->connector->send(new DeleteUserRequest($id))->json();
    }
}
