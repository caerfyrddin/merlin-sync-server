<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate;

use Caerfyrddin\MerlinSyncServer\Core\Data\Aggregate;
use Caerfyrddin\MerlinSyncServer\Core\Helper\DateTimeHelper;
use Caerfyrddin\MerlinSyncServer\Core\Persistence\MysqliDTO;
use Caerfyrddin\MerlinSyncServer\Core\ValueObject\Name;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FacePersonId;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
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

final class FacePerson extends Aggregate implements JsonSerializable, MysqliDTO
{

    private ?Name           $firstName;
    private ?Name           $lastName;
    private ?User           $scopeOwner;
    // TODO Add a face representation to easily recognize an person

    #[Pure]
    public function __construct(
        ?FacePersonId   $id,
        ?Name           $firstName,
        ?Name           $lastName,
        ?User           $scopeOwner,
        ?DateTime       $createdAt,
        ?DateTime       $modifiedAt
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->firstName    = $firstName;
        $this->lastName     = $lastName;
        $this->scopeOwner   = $scopeOwner;
    }

    public static function fromMysqliObject(object $object): static
    {
        return new self(
            FacePersonId::from($object->id),
            Name::from($object->first_name),
            Name::from($object->last_name),
            User::fromIdAsPlaceholder($object->scope_owner),
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
        Name            $firstName,
        Name            $lastName,
        UserId          $scopeOwnerId,
    ): self
    {
        return new self(
            null,
            $firstName,
            $lastName,
            User::fromIdAsPlaceholder($scopeOwnerId),
            new DateTime(),
            null,
        );
    }

    public function getFirstName(): Name
    {
        $this->checkNotInPlaceholderStatus();
        return $this->firstName;
    }

    public function setFirstName(Name $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): Name
    {
        $this->checkNotInPlaceholderStatus();
        return $this->lastName;
    }

    public function setLastName(Name $lastName): void
    {
        $this->lastName = $lastName;
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

    #[ArrayShape([
        'id'            => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\FacePersonId|null",
        'firstName'     => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\Name|null",
        'lastName'      => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\Name|null",
        'scopeOwner'    => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\User|null",
        'createdAt'     => "\DateTime|null",
        'modifiedAt'    => "\DateTime|null",
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->id,
            'firstName'     => $this->firstName,
            'lastName'      => $this->lastName,
            'scopeOwner'    => $this->scopeOwner,
            'createdAt'     => $this->createdAt,
            'modifiedAt'    => $this->modifiedAt,
        ];
    }
}
