<?php

namespace AutozNetwork\Plugins;

use AutozNetwork\AuthenticationType;
use AutozNetwork\Enums\EntityType;
use Saloon\Http\PendingRequest;

trait WithEntityID
{
    public ?EntityType $entityType = null;

    public ?int $entityId = null;

    public function bootWithEntityID(PendingRequest $pendingRequest): void
    {
        if (! is_null($this->entityType) && ! is_null($this->entityId)) {
            $pendingRequest->headers()->merge([
                "X-AutozNetwork-{$this->entityType->value}-Id" => $this->entityId,
            ]);
        }
    }

    public function entity(AuthenticationType $authenticationType): static
    {
        $this->entityType = $authenticationType->entityType;
        $this->entityId = $authenticationType->entityId;

        return $this;
    }

    public function withEntity(AuthenticationType $authenticationType): static
    {
        return $this->entity($authenticationType);
    }
}
