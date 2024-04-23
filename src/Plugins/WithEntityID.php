<?php

namespace AutozNetwork\Plugins;

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

    public function entity(EntityType $entityType, ?int $entityId): static
    {
        $this->entityType = $entityType;
        $this->entityId = $entityId;

        return $this;
    }

    public function withEntity(EntityType $entityType, ?int $entityId): static
    {
        return $this->entity($entityType, $entityId);
    }
}
