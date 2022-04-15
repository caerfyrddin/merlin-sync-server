<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate;

use Caerfyrddin\MerlinSyncServer\Core\Data\Aggregate;
use Caerfyrddin\MerlinSyncServer\Core\Helper\DateTimeHelper;
use Caerfyrddin\MerlinSyncServer\Core\Persistence\MysqliDTO;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FacePersonId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\Name;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * Face person
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class FacePerson extends Aggregate implements JsonSerializable, MysqliDTO
{

    private Name            $firstName;
    private Name            $lastName;
    // private User            $scopeOwner;
    private UserId          $scopeOwnerId;
    // TODO Add a face representation to easily recognize an person

    public function __construct(
        ?FacePersonId   $id,
        Name            $firstName,
        Name            $lastName,
        UserId          $scopeOwnerId,
        ?DateTime       $createdAt,
        ?DateTime       $modifiedAt
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->firstName    = $firstName;
        $this->lastName     = $lastName;
        $this->scopeOwnerId = $scopeOwnerId;
    }

    public static function fromMysqliObject(object $object): static
    {
        return new self(
            FacePersonId::from($object->id),
            Name::from($object->first_name),
            Name::from($object->last_name),
            UserId::from($object->scope_owner),
            DateTimeHelper::fromMysqliDateTime($object->created_at),
            DateTimeHelper::fromMysqliDateTime($object->modified_at)
        );
    }

    /**
     * Construct a newly-created, non-persisted user
     */
    public static function fromNew(
        Name            $firstName,
        Name            $lastName,
        UserId          $scopeOwnerId,
    ): self
    {
        return new self(
            null,
            $firstName,
            $lastName,
            $scopeOwnerId,
            new DateTime(),
            null,
        );
    }

    public function getFirstName(): Name
    {
        return $this->firstName;
    }

    public function setFirstName(Name $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): Name
    {
        return $this->lastName;
    }

    public function setLastName(Name $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getScopeOwnerId(): UserId
    {
        return $this->scopeOwnerId;
    }

    public function setScopeOwnerId(UserId $scopeOwnerId): void
    {
        $this->scopeOwnerId = $scopeOwnerId;
    }

    #[ArrayShape([
        'id'            => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FacePersonId",
        'firstName'     => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\Name",
        'lastName'      => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\Name",
        'scopeOwnerId'  => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId",
        'createdAt'     => "\DateTime",
        'modifiedAt'    => "\DateTime|null",
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->id,
            'firstName'     => $this->firstName,
            'lastName'      => $this->lastName,
            'scopeOwnerId'  => $this->scopeOwnerId,
            'createdAt'     => $this->createdAt,
            'modifiedAt'    => $this->modifiedAt,
        ];
    }
}
