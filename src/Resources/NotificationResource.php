<?php

namespace AutozNetwork\Resources;

use AutozNetwork\Requests\Notifications\CreateNotificationRequest;
use AutozNetwork\Requests\Notifications\DeleteNotificationRequest;
use AutozNetwork\Requests\Notifications\GetNotificationRequest;
use AutozNetwork\Requests\Notifications\ListNotificationsRequest;
use Saloon\Http\Response;

class NotificationResource extends BaseResource
{
    public function all(): Response
    {
        return $this->connector->send(new ListNotificationsRequest())->json();
    }

    public function get(int $id): Response
    {
        return $this->connector->send(new GetNotificationRequest($id))->json();
    }

    public function create(array $data): Response
    {
        return $this->connector->send(new CreateNotificationRequest($data))->json();
    }

    public function delete(int $id): Response
    {
        return $this->connector->send(new DeleteNotificationRequest($id))->json();
    }
}
