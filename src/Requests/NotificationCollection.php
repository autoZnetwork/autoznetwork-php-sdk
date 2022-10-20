<?php

namespace AutozNetwork\Requests;

use AutozNetwork\Requests\Notifications\CreateNotificationRequest;
use AutozNetwork\Requests\Notifications\DeleteNotificationRequest;
use AutozNetwork\Requests\Notifications\GetNotificationRequest;
use AutozNetwork\Requests\Notifications\ListNotificationsRequest;
use Sammyjo20\Saloon\Http\RequestCollection;

class NotificationCollection extends RequestCollection
{
    public function all()
    {
        $request = $this->connector->request(new ListNotificationsRequest);
        $response = $request->send();

        return $response->json();
    }

    public function get(int $id)
    {
        $request = $this->connector->request(new GetNotificationRequest($id));
        $response = $request->send();

        return $response->json();
    }

    public function create(array $data)
    {
        $request = $this->connector->request(new CreateNotificationRequest($data));
        $response = $request->send();

        return $response->json();
    }

    public function delete(int $id)
    {
        $request = $this->connector->request(new DeleteNotificationRequest($id));
        $response = $request->send();

        return $response->json();
    }
}
