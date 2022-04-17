<?php

namespace Caerfyrddin\MerlinSyncServer\Core\ValueObject;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * URL value object
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class Url implements JsonSerializable
{
    private string $url;

    private function __construct(string $url)
    {
        $this->setUrl($url);
    }

    public static function from(string $url): self
    {
        return new self($url);
    }

    public function url(): string
    {
        return $this->url;
    }

    #[Pure]
    public function equalsTo(self $url): bool
    {
        return $this->url() === $url->url();
    }

    #[Pure]
    public function jsonSerialize(): string
    {
        return $this->url();
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->url();
    }

    private function setUrl(string $url): void
    {
        // FIXME Validate URL
        $this->url = trim($url);
    }
}