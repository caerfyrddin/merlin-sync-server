<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate;

use Caerfyrddin\MerlinSyncServer\Core\Data\Aggregate;
use Caerfyrddin\MerlinSyncServer\Core\Helper\DateTimeHelper;
use Caerfyrddin\MerlinSyncServer\Core\Persistence\MysqliDTO;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AggregateId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumDescription;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumTitle;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Album
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class Album extends Aggregate implements JsonSerializable, MysqliDTO
{

    private ?AlbumTitle         $title;
    private ?AlbumDescription   $description;
    private ?User               $owner;
    private ?array              $photos;

    #[Pure]
    public function __construct(
        ?AlbumId            $id,
        ?AlbumTitle         $title,
        ?AlbumDescription   $description,
        ?User               $owner,
        ?DateTime           $createdAt,
        ?DateTime           $modifiedAt,
        ?array              $photos,
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->title        = $title;
        $this->description  = $description;
        $this->owner        = $owner;
        $this->photos       = $photos;
    }

    public static function fromMysqliObject(object $object): static
    {
        return new self(
            AlbumId::from($object->id),
            AlbumTitle::from($object->title),
            AlbumDescription::from($object->description),
            User::fromIdAsPlaceholder($object->owner),
            DateTimeHelper::fromMysqliDateTime($object->created_at),
            DateTimeHelper::fromMysqliDateTime($object->modified_at),
            null,
        );
    }

    public static function fromIdAsPlaceholder($id): static
    {
        $aggregate = new self($id, null, null, null, null, null, null);
        $aggregate->setPersistenceStatusAsPlaceholder();
        return $aggregate;
    }

    /**
     * Construct a newly-created, non-persisted user
     */
    public static function fromNew(
        AlbumTitle          $title,
        ?AlbumDescription   $description,
        UserId              $ownerId,
    ): self
    {
        return new self(
            null,
            $title,
            $description,
            User::fromIdAsPlaceholder($ownerId),
            new DateTime(),
            null,
            null,
        );
    }

    public function getTitle(): ?AlbumTitle
    {
        $this->checkNotInPlaceholderStatus();
        return $this->title;
    }

    public function setTitle(AlbumTitle $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?AlbumDescription
    {
        $this->checkNotInPlaceholderStatus();
        return $this->description;
    }

    public function setDescription(?AlbumDescription $description): void
    {
        $this->description = $description;
    }

    public function getOwner(): User
    {
        $this->checkForeignAggregateRetrieved($this->owner);
        return $this->owner;
    }

    public function setOwner(?User $owner): void
    {
        $this->owner = $owner;
    }

    public function getPhotos(): array
    {
        $this->checkToManyPopulated($this->photos);
        return $this->photos;
    }

    #[ArrayShape([
        'id'            => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumId|null",
        'title'         => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumTitle|null",
        'description'   => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumDescription|null",
        'owner'         => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate\User|null",
        'photos'        => "array|null",
        'createdAt'     => "\DateTime|null",
        'modifiedAt'    => "\DateTime|null",
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'owner'         => $this->owner,
            'photos'        => $this->photos,
            'createdAt'     => $this->createdAt,
            'modifiedAt'    => $this->modifiedAt,
        ];
    }
}
