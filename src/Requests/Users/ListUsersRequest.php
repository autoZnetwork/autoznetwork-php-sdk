<?php

namespace Autoznetwork\AutozNetwork\Requests\Users;

use Autoznetwork\AutozNetwork\Traits\RequiresEntityId;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListUsersRequest extends Request
{
    use RequiresEntityId;

    protected Method $method = Method::GET;

    /**
     * @param  array<string, mixed>  $params
     */
    public function __construct(
        protected readonly array $params = [],
    ) {}

    public function resolveEndpoint(): string
    {
        return '/users';
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return $this->params;
    }
}
