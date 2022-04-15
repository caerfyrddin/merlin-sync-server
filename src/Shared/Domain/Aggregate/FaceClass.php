<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate;

use Caerfyrddin\MerlinSyncServer\Core\Data\Aggregate;
use Caerfyrddin\MerlinSyncServer\Core\Helper\DateTimeHelper;
use Caerfyrddin\MerlinSyncServer\Core\Persistence\MysqliDTO;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceClassId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceEmbedding;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FacePersonId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\Name;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * Face class
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class FaceClass extends Aggregate implements JsonSerializable, MysqliDTO
{

    // private ?User           $scopeOwner;
    private UserId          $scopeOwnerId;
    private FaceEmbedding   $meanEmbedding;
    // private ?FacePerson     $personAssociation;
    private FacePersonId    $personAssociationId;

    public function __construct(
        ?FaceClassId   $id,
        UserId          $scopeOwnerId,
        FaceEmbedding   $meanEmbedding,
        FacePersonId    $personAssociationId,
        ?DateTime       $createdAt,
        ?DateTime       $modifiedAt
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->scopeOwnerId         = $scopeOwnerId;
        $this->meanEmbedding        = $meanEmbedding;
        $this->personAssociationId    = $personAssociationId;
    }

    public static function fromMysqliObject(object $object): static
    {
        return new self(
            FaceClassId::from($object->id),
            UserId::from($object->scope_owner),
            FaceEmbedding::fromJsonString($object->mean_embedding),
            FacePersonId::from($object->person_association),
            DateTimeHelper::fromMysqliDateTime($object->created_at),
            DateTimeHelper::fromMysqliDateTime($object->modified_at)
        );
    }

    /**
     * Construct a newly-created, non-persisted user
     */
    public static function fromNew(
        UserId          $scopeOwnerId,
        FaceEmbedding   $meanEmbedding,
        FacePersonId    $personAssociationId,
    ): self
    {
        return new self(
            null,
            $scopeOwnerId,
            $meanEmbedding,
            $personAssociationId,
            new DateTime(),
            null,
        );
    }

    public function getScopeOwnerId(): UserId
    {
        return $this->scopeOwnerId;
    }

    public function setScopeOwnerId(UserId $scopeOwnerId): void
    {
        $this->scopeOwnerId = $scopeOwnerId;
    }

    public function getMeanEmbedding(): FaceEmbedding
    {
        return $this->meanEmbedding;
    }

    public function setMeanEmbedding(FaceEmbedding $meanEmbedding): void
    {
        $this->meanEmbedding = $meanEmbedding;
    }

    public function getPersonAssociationId(): FacePersonId
    {
        return $this->personAssociationId;
    }

    public function setPersonAssociationId(FacePersonId $personAssociationId): void
    {
        $this->personAssociationId = $personAssociationId;
    }

    #[ArrayShape([
        'id'                    => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FacePersonId",
        'scopeOwnerId'          => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId",
        'meanEmbedding'         => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceEmbedding",
        'personAssociationId'   => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FacePersonId",
        'createdAt'             => "\DateTime",
        'modifiedAt'            => "\DateTime|null",
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id'                    => $this->id,
            'scopeOwnerId'          => $this->scopeOwnerId,
            'meanEmbedding'         => $this->meanEmbedding,
            'personAssociationId'   => $this->personAssociationId,
            'createdAt'             => $this->createdAt,
            'modifiedAt'            => $this->modifiedAt,
        ];
    }
}
