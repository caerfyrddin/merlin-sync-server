<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Album title value object
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class AlbumTitle implements JsonSerializable
{
    private string $title;

    private function __construct(string $title)
    {
        $this->setTitle($title);
    }

    public static function from(string $title): self
    {
        return new self($title);
    }

    public function title(): string
    {
        return $this->title;
    }

    #[Pure]
    public function equalsTo(self $title): bool
    {
        return $this->title() === $title->title();
    }

    #[Pure]
    public function jsonSerialize(): string
    {
        return $this->title();
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->title();
    }

    private function setTitle(string $title): void
    {
        // FIXME Assertion::notBlank($title);
        $this->title = trim($title);
    }
}