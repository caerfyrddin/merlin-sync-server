<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;
use Stringable;

/**
 * Aggregate id value object
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class AggregateId implements JsonSerializable, Stringable
{
    private int $aggregateId;

    private function __construct(int $aggregateId)
    {
        $this->setId($aggregateId);
    }

    public static function from(int $aggregateId): static
    {
        return new self($aggregateId);
    }

    public function aggregateId(): int
    {
        return $this->aggregateId;
    }

    #[Pure]
    public function equalsTo(self $memberId): bool
    {
        return $this->aggregateId() === $memberId->aggregateId();
    }

    #[Pure]
    public function jsonSerialize(): int
    {
        return $this->aggregateId();
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->aggregateId();
    }

    private function setId(int $aggregateId): void
    {
        // FIXME Assertion::uuid($aggregateId);
        $this->aggregateId = $aggregateId;
    }
}