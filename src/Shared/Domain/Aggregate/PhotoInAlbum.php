<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate;

use Caerfyrddin\MerlinSyncServer\Core\Attribute\Required;
use Caerfyrddin\MerlinSyncServer\Core\Data\Aggregate;
use Caerfyrddin\MerlinSyncServer\Core\Helper\DateTimeHelper;
use Caerfyrddin\MerlinSyncServer\Core\Persistence\MysqliDTO;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AggregateId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceClassId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceEmbedding;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceInPhotoId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoInAlbumId;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Photo in album
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class PhotoInAlbum extends Aggregate implements JsonSerializable, MysqliDTO
{

    #[Required]
    private ?Photo  $photo;
    #[Required]
    private ?Album  $album;

    #[Pure]
    public function __construct(
        ?PhotoInAlbumId $id,
        ?Photo          $photo,
        ?Album          $album,
        ?DateTime       $createdAt,
        ?DateTime       $modifiedAt
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->photo    = $photo;
        $this->album    = $album;
    }

    public static function fromMysqliObject(object $object): static
    {
        return new self(
            PhotoInAlbumId::from($object->id),
            Photo::fromIdAsPlaceholder($object->photo),
            Album::fromIdAsPlaceholder($object->album),
            DateTimeHelper::fromMysqliDateTime($object->created_at),
            DateTimeHelper::fromMysqliDateTime($object->modified_at),
        );
    }

    public static function fromIdAsPlaceholder($id): static
    {
        $aggregate = new self($id, null, null, null, null);
        $aggregate->setPersistenceStatusAsPlaceholder();
        return $aggregate;
    }

    /**
     * Construct a newly-created, non-persisted user
     */
    public static function fromNew(
        PhotoId $photoId,
        AlbumId $albumId,
    ): self
    {
        return new self(
            null,
            Photo::fromIdAsPlaceholder($photoId),
            Album::fromIdAsPlaceholder($albumId),
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

    public function getAlbum(): ?Album
    {
        $this->checkForeignAggregateRetrieved($this->photo);
        return $this->album;
    }

    public function setAlbum(?Album $album): void
    {
        $this->album = $album;
    }

    #[ArrayShape([
        'id' => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AggregateId|null",
        'photo' => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate\Photo|null",
        'album' => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate\Album|null",
        'createdAt' => "\DateTime|null",
        'modifiedAt' => "\DateTime|null"
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->id,
            'photo'         => $this->photo,
            'album'         => $this->album,
            'createdAt'     => $this->createdAt,
            'modifiedAt'    => $this->modifiedAt,
        ];
    }
}
