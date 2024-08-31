<?php

namespace AutozNetwork;

use AutozNetwork\Enums\EntityType;

class AuthenticationType
{
    public function __construct(public EntityType $entityType, public int $entityId) {}
}
