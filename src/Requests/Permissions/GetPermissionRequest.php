<?php

namespace AutozNetwork\Requests\Permissions;

use AutozNetwork\Requests\Request;
use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Traits\Plugins\AcceptsJson;

class GetPermissionRequest extends Request
{
    use AcceptsJson;
    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::GET;

    /**
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/permissions/'.$this->permissionId;
    }

    public function __construct(
        public int $permissionId
    ) {
    }
}
