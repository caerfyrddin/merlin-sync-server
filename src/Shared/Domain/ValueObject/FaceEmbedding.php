<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Face embedding value object
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class FaceEmbedding implements JsonSerializable
{
    private array $faceEmbedding;

    private function __construct(array $faceEmbedding)
    {
        $this->setFaceEmbedding($faceEmbedding);
    }

    public static function from(array $faceEmbedding): self
    {
        return new self($faceEmbedding);
    }

    public static function fromJsonString(string $string): self
    {
        return new self(json_decode($string));
    }

    public function faceEmbedding(): array
    {
        return $this->faceEmbedding;
    }

    #[Pure]
    public function equalsTo(self $faceEmbedding): bool
    {
        return $this->faceEmbedding() === $faceEmbedding->faceEmbedding();
    }

    #[Pure]
    public function jsonSerialize(): array
    {
        return $this->faceEmbedding();
    }

    public function __toString(): string
    {
        return json_encode($this->faceEmbedding());
    }

    private function setFaceEmbedding(array $faceEmbedding): void
    {
        // FIXME Assertion:: length 128
        $this->faceEmbedding = $faceEmbedding;
    }
}