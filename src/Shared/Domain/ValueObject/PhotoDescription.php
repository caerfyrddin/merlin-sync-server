<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Photo description value object
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class PhotoDescription implements JsonSerializable
{
    private string $description;

    private function __construct(string $description)
    {
        $this->setDescription($description);
    }

    public static function from(string $description): self
    {
        return new self($description);
    }

    public function description(): string
    {
        return $this->description;
    }

    #[Pure]
    public function equalsTo(self $description): bool
    {
        return $this->description() === $description->description();
    }

    #[Pure]
    public function jsonSerialize(): string
    {
        return $this->description();
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->description();
    }

    private function setDescription(string $description): void
    {
        // FIXME Assertion::notBlank($title);
        $this->description = trim($description);
    }
}