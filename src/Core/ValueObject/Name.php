<?php

namespace Caerfyrddin\MerlinSyncServer\Core\ValueObject;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Name value object
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class Name implements JsonSerializable
{
    private string $name;

    private function __construct(string $name)
    {
        $this->setName($name);
    }

    public static function from(string $name): self
    {
        return new self($name);
    }

    public function name(): string
    {
        return $this->name;
    }

    #[Pure]
    public function equalsTo(self $name): bool
    {
        return $this->name() === $name->name();
    }

    #[Pure]
    public function jsonSerialize(): string
    {
        return $this->name();
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->name();
    }

    private function setName(string $name): void
    {
        // FIXME Assertion::notBlank($name);
        $this->name = trim($name);
    }
}