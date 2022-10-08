<?php

namespace AutozNetwork\Requests\Notifications;

use AutozNetwork\Requests\Request;
use AutozNetwork\Traits\RequiresOrganizationID;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;
use Sammyjo20\Saloon\Traits\Plugins\HasJsonBody;

class DeleteNotificationRequest extends Request
{
    use HasJsonBody;
    use AcceptsJson;
    use RequiresOrganizationID;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::DELETE;

    /**
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/notifications/'.$this->notificationId;
    }

    public function __construct(
        public int $notificationId
    ) {
    }
}
