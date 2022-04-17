<?php

namespace Caerfyrddin\MerlinSyncServer\Core\ValueObject;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Directory path value object
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class DirectoryPath implements JsonSerializable
{
    private string $directoryPath;

    private function __construct(string $directoryPath)
    {
        $this->setDirectoryPath($directoryPath);
    }

    public static function from(string $directoryPath): self
    {
        return new self($directoryPath);
    }

    public function directoryPath(): string
    {
        return $this->directoryPath;
    }

    #[Pure]
    public function equalsTo(self $directoryPath): bool
    {
        return $this->directoryPath() === $directoryPath->directoryPath();
    }

    #[Pure]
    public function jsonSerialize(): string
    {
        return $this->directoryPath();
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->directoryPath();
    }

    private function setDirectoryPath(string $directoryPath): void
    {
        // FIXME Assertion::notBlank($directoryPath);
        $this->directoryPath = trim($directoryPath);
    }
}