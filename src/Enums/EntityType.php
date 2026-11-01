<?php

namespace Autoznetwork\AutozNetwork\Enums;

/**
 * The two kinds of tenant an API call can be scoped to.
 */
enum EntityType: string
{
    case ORGANIZATION = 'organization';

    case ENTERPRISE = 'enterprise';

    /**
     * The header that carries this entity's id.
     */
    public function header(): string
    {
        return match ($this) {
            self::ORGANIZATION => 'X-AutozNetwork-Organization-Id',
            self::ENTERPRISE => 'X-AutozNetwork-Enterprise-Id',
        };
    }
}
