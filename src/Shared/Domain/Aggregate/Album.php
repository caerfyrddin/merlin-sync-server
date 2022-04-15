<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate;

use Caerfyrddin\MerlinSyncServer\Core\Data\Aggregate;
use Caerfyrddin\MerlinSyncServer\Core\Helper\DateTimeHelper;
use Caerfyrddin\MerlinSyncServer\Core\Persistence\MysqliDTO;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\Type\UserRoleType;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\Type\UserStatusType;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AggregateId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumDescription;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumTitle;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\EmailAddress;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\Name;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
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

class Album extends Aggregate implements JsonSerializable, MysqliDTO
{

    private AlbumTitle          $title;
    private ?AlbumDescription   $description;
    // private ?User               $owner;
    private UserId              $ownerId;

    public function __construct(
        ?AlbumId            $id,
        AlbumTitle          $title,
        ?AlbumDescription   $description,
        UserId              $ownerId,
        ?DateTime           $createdAt,
        ?DateTime           $modifiedAt
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->title        = $title;
        $this->description  = $description;
        $this->ownerId      = $ownerId;
    }

    public static function fromMysqliObject(object $object): static
    {
        return new self(
            AlbumId::from($object->id),
            AlbumTitle::from($object->title),
            AlbumDescription::from($object->description),
            UserId::from($object->owner),
            DateTimeHelper::fromMysqliDateTime($object->created_at),
            DateTimeHelper::fromMysqliDateTime($object->modified_at),
        );
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
            $ownerId,
            new DateTime(),
            null,
        );
    }

    #[ArrayShape([
        'id'            => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumId",
        'title'         => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumTitle",
        'description'   => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AlbumDescription|null",
        'ownerId'       => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId",
        'createdAt'     => "\DateTime", 'modifiedAt' => "\DateTime|null"
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'ownerId'       => $this->ownerId,
            'createdAt'     => $this->createdAt,
            'modifiedAt'    => $this->modifiedAt,
        ];
    }
}
