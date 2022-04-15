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

class FaceInPhoto extends Aggregate implements JsonSerializable, MysqliDTO
{

    // private ?Photo          $photo;
    private PhotoId         $photoId;
    // private ?FaceClass      $faceClass;
    private FaceClassId     $faceClassId;
    private FaceEmbedding   $embedding;
    private int             $rectTop;
    private int             $rectRight;
    private int             $rectBottom;
    private int             $rectLeft;

    public function __construct(
        ?FaceInPhotoId  $id,
        PhotoId         $photoId,
        FaceClassId     $faceClassId,
        FaceEmbedding   $embedding,
        int             $rectTop,
        int             $rectRight,
        int             $rectBottom,
        int             $rectLeft,
        ?DateTime       $createdAt,
        ?DateTime       $modifiedAt
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->photoId      = $photoId;
        $this->faceClassId  = $faceClassId;
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
            PhotoId::from($object->photo),
            FaceClassId::from($object->face_class),
            FaceEmbedding::fromJsonString($object->embedding),
            $object->rect_top,
            $object->rect_right,
            $object->rect_bottom,
            $object->rect_left,
            DateTimeHelper::fromMysqliDateTime($object->created_at),
            DateTimeHelper::fromMysqliDateTime($object->modified_at),
        );
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
            $photoId,
            $faceClassId,
            $embedding,
            $rectTop,
            $rectRight,
            $rectBottom,
            $rectLeft,
            new DateTime(),
            null,
        );
    }

    public function getPhotoId(): PhotoId
    {
        return $this->photoId;
    }

    public function setPhotoId(PhotoId $photoId): void
    {
        $this->photoId = $photoId;
    }

    public function getFaceClassId(): FaceClassId
    {
        return $this->faceClassId;
    }

    public function setFaceClassId(FaceClassId $faceClassId): void
    {
        $this->faceClassId = $faceClassId;
    }

    public function getEmbedding(): FaceEmbedding
    {
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
        return $this->rectRight;
    }

    public function setRectRight(int $rectRight): void
    {
        $this->rectRight = $rectRight;
    }

    public function getRectBottom(): int
    {
        return $this->rectBottom;
    }

    public function setRectBottom(int $rectBottom): void
    {
        $this->rectBottom = $rectBottom;
    }

    public function getRectLeft(): int
    {
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
            'photoId'       => $this->photoId,
            'faceClassId'   => $this->faceClassId,
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
