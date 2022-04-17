<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate;

use Caerfyrddin\MerlinSyncServer\Core\Data\Aggregate;
use Caerfyrddin\MerlinSyncServer\Core\Helper\DateTimeHelper;
use Caerfyrddin\MerlinSyncServer\Core\Persistence\MysqliDTO;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceClassId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceEmbedding;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FacePersonId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
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

final class FaceClass extends Aggregate implements JsonSerializable, MysqliDTO
{

    private ?User           $scopeOwner;
    private ?FaceEmbedding  $meanEmbedding;
    private ?FacePerson     $associatedPerson;

    #[Pure]
    public function __construct(
        ?FaceClassId    $id,
        ?User           $scopeOwner,
        ?FaceEmbedding  $meanEmbedding,
        ?FacePerson     $associatedPerson,
        ?DateTime       $createdAt,
        ?DateTime       $modifiedAt
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->scopeOwner           = $scopeOwner;
        $this->meanEmbedding        = $meanEmbedding;
        $this->associatedPerson     = $associatedPerson;
    }

    public static function fromMysqliObject(object $object): static
    {
        return new self(
            FaceClassId::from($object->id),
            User::fromIdAsPlaceholder($object->scope_owner),
            FaceEmbedding::fromJsonString($object->mean_embedding),
            FacePerson::fromIdAsPlaceholder($object->associated_person),
            DateTimeHelper::fromMysqliDateTime($object->created_at),
            DateTimeHelper::fromMysqliDateTime($object->modified_at)
        );
    }

    public static function fromIdAsPlaceholder($id): static
    {
        $aggregate = new self($id, null, null, null, null, null);
        $aggregate->setPersistenceStatusAsPlaceholder();
        return $aggregate;
    }

    /**
     * Construct a newly-created, non-persisted user
     */
    public static function fromNew(
        UserId          $scopeOwnerId,
        FaceEmbedding   $meanEmbedding,
        FacePersonId    $associatedPersonId,
    ): self
    {
        return new self(
            null,
            User::fromIdAsPlaceholder($scopeOwnerId),
            $meanEmbedding,
            FacePerson::fromIdAsPlaceholder($associatedPersonId),
            new DateTime(),
            null,
        );
    }

    public function getScopeOwner(): User
    {
        $this->checkForeignAggregateRetrieved($this->scopeOwner);
        return $this->scopeOwner;
    }

    public function setScopeOwner(User $scopeOwner): void
    {
        $this->scopeOwner = $scopeOwner;
    }

    public function getMeanEmbedding(): FaceEmbedding
    {
        $this->checkNotInPlaceholderStatus();
        return $this->meanEmbedding;
    }

    public function setMeanEmbedding(FaceEmbedding $meanEmbedding): void
    {
        $this->meanEmbedding = $meanEmbedding;
    }

    public function getAssociatedPerson(): FacePerson
    {
        $this->checkForeignAggregateRetrieved($this->associatedPerson);
        return $this->associatedPerson;
    }

    public function setAssociatedPerson(FacePerson $associatedPerson): void
    {
        $this->associatedPerson = $associatedPerson;
    }

    #[ArrayShape([
        'id'                    => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FacePersonId|null",
        'scopeOwner'            => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate\User|null",
        'meanEmbedding'         => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FaceEmbedding|null",
        'associatedPerson'      => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate\FacePerson|null",
        'createdAt'             => "\DateTime|null",
        'modifiedAt'            => "\DateTime|null",
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id'                    => $this->id,
            'scopeOwner'            => $this->scopeOwner,
            'meanEmbedding'         => $this->meanEmbedding,
            'associatedPerson'      => $this->associatedPerson,
            'createdAt'             => $this->createdAt,
            'modifiedAt'            => $this->modifiedAt,
        ];
    }
}
