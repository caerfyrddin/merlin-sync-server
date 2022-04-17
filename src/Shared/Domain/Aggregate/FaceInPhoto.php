<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate;

use Caerfyrddin\MerlinSyncServer\Core\Data\Aggregate;
use Caerfyrddin\MerlinSyncServer\Core\Helper\DateTimeHelper;
use Caerfyrddin\MerlinSyncServer\Core\Persistence\MysqliDTO;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceClassId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceEmbedding;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceInPhotoId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoId;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Face in photo
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class FaceInPhoto extends Aggregate implements JsonSerializable, MysqliDTO
{

    private ?Photo          $photo;
    private ?FaceClass      $faceClass;
    private ?FaceEmbedding  $embedding;
    private ?int            $rectTop;
    private ?int            $rectRight;
    private ?int            $rectBottom;
    private ?int            $rectLeft;

    #[Pure]
    public function __construct(
        ?FaceInPhotoId  $id,
        ?Photo          $photo,
        ?FaceClass      $faceClass,
        ?FaceEmbedding  $embedding,
        ?int            $rectTop,
        ?int            $rectRight,
        ?int            $rectBottom,
        ?int            $rectLeft,
        ?DateTime       $createdAt,
        ?DateTime       $modifiedAt
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->photo        = $photo;
        $this->faceClass    = $faceClass;
        $this->embedding    = $embedding;
        $this->rectTop      = $rectTop;
        $this->rectRight    = $rectRight;
        $this->rectBottom   = $rectBottom;
        $this->rectLeft     = $rectLeft;
    }

    public static function fromMysqliObject(object $object): static
    {
        return new self(
            FaceInPhotoId::from($object->id),
            Photo::fromIdAsPlaceholder($object->photo),
            FaceClass::fromIdAsPlaceholder($object->face_class),
            FaceEmbedding::fromJsonString($object->embedding),
            $object->rect_top,
            $object->rect_right,
            $object->rect_bottom,
            $object->rect_left,
            DateTimeHelper::fromMysqliDateTime($object->created_at),
            DateTimeHelper::fromMysqliDateTime($object->modified_at),
        );
    }

    public static function fromIdAsPlaceholder($id): static
    {
        $aggregate = new self($id, null, null, null, null, null, null, null, null, null);
        $aggregate->setPersistenceStatusAsPlaceholder();
        return $aggregate;
    }

    /**
     * Construct a newly-created, non-persisted user
     */
    public static function fromNew(
        PhotoId         $photoId,
        FaceClassId     $faceClassId,
        FaceEmbedding   $embedding,
        int             $rectTop,
        int             $rectRight,
        int             $rectBottom,
        int             $rectLeft,
    ): self
    {
        return new self(
            null,
            Photo::fromIdAsPlaceholder($photoId),
            FaceClass::fromIdAsPlaceholder($faceClassId),
            $embedding,
            $rectTop,
            $rectRight,
            $rectBottom,
            $rectLeft,
            new DateTime(),
            null,
        );
    }

    public function getPhoto(): Photo
    {
        $this->checkForeignAggregateRetrieved($this->photo);
        return $this->photo;
    }

    public function setPhoto(Photo $photo): void
    {
        $this->photo = $photo;
    }

    public function getFaceClass(): FaceClass
    {
        $this->checkForeignAggregateRetrieved($this->faceClass);
        return $this->faceClass;
    }

    public function setFaceClass(FaceClass $faceClass): void
    {
        $this->faceClass = $faceClass;
    }

    public function getEmbedding(): FaceEmbedding
    {
        $this->checkNotInPlaceholderStatus();
        return $this->embedding;
    }

    public function setEmbedding(FaceEmbedding $embedding): void
    {
        $this->embedding = $embedding;
    }

    public function getRectTop(): int
    {
        return $this->rectTop;
    }

    public function setRectTop(int $rectTop): void
    {
        $this->rectTop = $rectTop;
    }

    public function getRectRight(): int
    {
        $this->checkNotInPlaceholderStatus();
        return $this->rectRight;
    }

    public function setRectRight(int $rectRight): void
    {
        $this->rectRight = $rectRight;
    }

    public function getRectBottom(): int
    {
        $this->checkNotInPlaceholderStatus();
        return $this->rectBottom;
    }

    public function setRectBottom(int $rectBottom): void
    {
        $this->rectBottom = $rectBottom;
    }

    public function getRectLeft(): int
    {
        $this->checkNotInPlaceholderStatus();
        return $this->rectLeft;
    }

    public function setRectLeft(int $rectLeft): void
    {
        $this->rectLeft = $rectLeft;
    }

    #[ArrayShape([
        'top' => "int",
        'right' => "int",
        'bottom' => "int",
        'left' => "int"
    ])]
    public function getRect(): array
    {
        $this->checkNotInPlaceholderStatus();
        return [
            'top'       => $this->rectTop,
            'right'     => $this->rectRight,
            'bottom'    => $this->rectBottom,
            'left'      => $this->rectLeft,
        ];
    }

    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->id,
            'photo'         => $this->photo,
            'faceClass'     => $this->faceClass,
            'embedding'     => $this->embedding,
            'rectTop'       => $this->rectTop,
            'rectRight'     => $this->rectRight,
            'rectBottom'    => $this->rectBottom,
            'rectLeft'      => $this->rectLeft,
            'createdAt'     => $this->createdAt,
            'modifiedAt'    => $this->modifiedAt,
        ];
    }
}
