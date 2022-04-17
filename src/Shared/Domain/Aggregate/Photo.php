<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate;

use Caerfyrddin\MerlinSyncServer\Core\Data\Aggregate;
use Caerfyrddin\MerlinSyncServer\Core\Helper\DateTimeHelper;
use Caerfyrddin\MerlinSyncServer\Core\Persistence\MysqliDTO;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\Type\PhotoOriginClientType;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\Type\PhotoProcessingStatusType;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\Type\PhotoSyncStatusType;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AggregateId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\DirectoryPath;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoDescription;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoOriginDescription;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoTitle;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use JsonSerializable;

/**
 * Photo
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class Photo extends Aggregate implements JsonSerializable, MysqliDTO
{

    private ?User                       $owner;
    private ?PhotoTitle                 $title;
    private ?PhotoDescription           $description;
    private ?DateTime                   $takenAt;
    private ?PhotoOriginClientType      $originClient;
    private ?PhotoOriginDescription     $originDescription;
    private ?DirectoryPath              $originDirectory;
    private ?PhotoSyncStatusType        $syncStatus;
    private ?PhotoProcessingStatusType  $processingStatus;

    private static PhotoSyncStatusType          $DEFAULT_SYNC_STATUS        = PhotoSyncStatusType::Pending;
    private static PhotoProcessingStatusType    $DEFAULT_PROCESSING_STATUS  = PhotoProcessingStatusType::Pending;

    #[Pure]
    public function __construct(
        ?PhotoId                    $id,
        ?User                       $owner,
        ?PhotoTitle                 $title,
        ?PhotoDescription           $description,
        ?DateTime                   $takenAt,
        ?PhotoOriginClientType      $originClient,
        ?PhotoOriginDescription     $originDescription,
        ?DirectoryPath              $originDirectory,
        ?PhotoSyncStatusType        $syncStatus,
        ?PhotoProcessingStatusType  $processingStatus,
        ?DateTime                   $createdAt,
        ?DateTime                   $modifiedAt,
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->owner                = $owner;
        $this->title                = $title;
        $this->description          = $description;
        $this->takenAt              = $takenAt;
        $this->originClient         = $originClient;
        $this->originDescription    = $originDescription;
        $this->originDirectory      = $originDirectory;
        $this->syncStatus           = $syncStatus;
        $this->processingStatus     = $processingStatus;
    }

    public static function fromMysqliObject(object $object): static
    {
        return new self(
            PhotoId::from($object->id),
            User::fromIdAsPlaceholder($object->owner),
            PhotoTitle::from($object->title),
            PhotoDescription::from($object->description),
            DateTimeHelper::fromMysqliDateTime($object->taken_at),
            PhotoOriginClientType::from($object->origin_client),
            PhotoOriginDescription::from($object->origin_description),
            DirectoryPath::from($object->origin_directory),
            PhotoSyncStatusType::from($object->sync_status),
            PhotoProcessingStatusType::from($object->processing_status),
            DateTimeHelper::fromMysqliDateTime($object->created_at),
            DateTimeHelper::fromMysqliDateTime($object->modified_at),
        );
    }

    public static function fromIdAsPlaceholder($id) : static
    {
        $aggregate = new self($id, null, null, null, null, null, null, null, null, null, null, null);
        $aggregate->setPersistenceStatusAsPlaceholder();
        return $aggregate;
    }

    /**
     * Construct a newly-created, non-persisted user
     */
    public static function fromNew(
        UserId                      $ownerId,
        ?PhotoTitle                 $title,
        ?PhotoDescription           $description,
        ?DateTime                   $takenAt,
        PhotoOriginClientType       $originClient,
        ?PhotoOriginDescription     $originDescription,
        ?DirectoryPath              $originDirectory,
    ): self
    {
        return new self(
            null,
            User::fromIdAsPlaceholder($ownerId),
            $title,
            $description,
            $takenAt,
            $originClient,
            $originDescription,
            $originDirectory,
            self::$DEFAULT_SYNC_STATUS,
            self::$DEFAULT_PROCESSING_STATUS,
            new DateTime(),
            null
        );
    }

    public function getOwner(): User
    {
        $this->checkForeignAggregateRetrieved($this->owner);
        return $this->owner;
    }

    public function setOwner(User $owner): void
    {
        $this->owner = $owner;
    }

    public function getTitle(): ?PhotoTitle
    {
        $this->checkNotInPlaceholderStatus();
        return $this->title;
    }

    public function setTitle(?PhotoTitle $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?PhotoDescription
    {
        $this->checkNotInPlaceholderStatus();
        return $this->description;
    }

    public function setDescription(?PhotoDescription $description): void
    {
        $this->description = $description;
    }

    public function getTakenAt(): ?DateTime
    {
        $this->checkNotInPlaceholderStatus();
        return $this->takenAt;
    }

    public function setTakenAt(?DateTime $takenAt): void
    {
        $this->takenAt = $takenAt;
    }

    public function getOriginClient(): PhotoOriginClientType
    {
        $this->checkNotInPlaceholderStatus();
        return $this->originClient;
    }

    public function setOriginClient(PhotoOriginClientType $originClient): void
    {
        $this->originClient = $originClient;
    }

    public function getOriginDescription(): ?PhotoOriginDescription
    {
        $this->checkNotInPlaceholderStatus();
        return $this->originDescription;
    }

    public function setOriginDescription(?PhotoOriginDescription $originDescription): void
    {
        $this->originDescription = $originDescription;
    }

    public function getOriginDirectory(): ?DirectoryPath
    {
        $this->checkNotInPlaceholderStatus();
        return $this->originDirectory;
    }

    public function setOriginDirectory(?DirectoryPath $originDirectory): void
    {
        $this->originDirectory = $originDirectory;
    }

    public function getSyncStatus(): PhotoSyncStatusType
    {
        $this->checkNotInPlaceholderStatus();
        return $this->syncStatus;
    }

    public function setSyncStatus(PhotoSyncStatusType $syncStatus): void
    {
        $this->syncStatus = $syncStatus;
    }

    public function getProcessingStatus(): PhotoProcessingStatusType
    {
        $this->checkNotInPlaceholderStatus();
        return $this->processingStatus;
    }

    public function setProcessingStatus(PhotoProcessingStatusType $processingStatus): void
    {
        $this->processingStatus = $processingStatus;
    }

    #[ArrayShape([
        'id'                => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoId|null",
        'owner'             => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\User|null",
        'title'             => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoTitle|null",
        'description'       => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoDescription|null",
        'takenAt'           => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\DateTime|null",
        'originClient'      => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoOriginClientType|null",
        'originDescription' => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoOriginDescription|null",
        'originDirectory'   => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\DirectoryPath|null",
        'syncStatus'        => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoSyncStatusType|null",
        'processingStatus'  => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\PhotoProcessingStatusType|null",
        'createdAt'         => "\DateTime|null",
        'modifiedAt'        => "\DateTime|null",
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id'                => $this->id,
            'owner'           => $this->owner,
            'title'             => $this->title,
            'description'       => $this->description,
            'takenAt'           => $this->takenAt,
            'originClient'      => $this->originClient,
            'originDescription' => $this->originDescription,
            'originDirectory'   => $this->originDirectory,
            'syncStatus'        => $this->syncStatus,
            'processingStatus'  => $this->processingStatus,
            'createdAt'         => $this->createdAt,
            'modifiedAt'        => $this->modifiedAt,
        ];
    }
}
