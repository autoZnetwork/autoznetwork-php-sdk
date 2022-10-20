<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Users\DeleteUserRequest;
use AutozNetwork\Requests\Users\GetUserRequest;
use AutozNetwork\Requests\Users\ListUsersRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class UserCollection extends RequestCollection
{
    public function all()
    {
        $request = $this->connector->request(new ListUsersRequest);
        $response = $request->send();

        return $response->json();
    }

    public function get(int $id)
    {
        $request = $this->connector->request(new GetUserRequest($id));
        $response = $request->send();

        return $response->json();
    }

    public function delete(int $id)
    {
        $request = $this->connector->request(new DeleteUserRequest($id));
        $response = $request->send();

        return $response->json();
    }
}
