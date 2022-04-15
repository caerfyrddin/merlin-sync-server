<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Aggregate;

use Caerfyrddin\MerlinSyncServer\Core\Data\Aggregate;
use Caerfyrddin\MerlinSyncServer\Core\Helper\DateTimeHelper;
use Caerfyrddin\MerlinSyncServer\Core\Persistence\MysqliDTO;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\Type\UserRoleType;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\Type\UserStatusType;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\EmailAddress;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\Name;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * User
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class User extends Aggregate implements JsonSerializable, MysqliDTO
{

    private Name            $firstName;
    private Name            $lastName;
    private EmailAddress    $emailAddress;
    private UserRoleType    $role;
    private UserStatusType  $status;

    private static UserStatusType $defaultStatus = UserStatusType::Enabled;

    public function __construct(
        ?UserId         $id,
        Name            $firstName,
        Name            $lastName,
        EmailAddress    $emailAddress,
        UserRoleType    $role,
        UserStatusType  $status,
        ?DateTime       $createdAt,
        ?DateTime       $modifiedAt
    )
    {
        parent::__construct($id, $createdAt, $modifiedAt);
        $this->firstName    = $firstName;
        $this->lastName     = $lastName;
        $this->emailAddress = $emailAddress;
        $this->role         = $role;
        $this->status       = $status;
    }

    public static function fromMysqliObject(object $object): static
    {
        return new self(
            UserId::from($object->id),
            Name::from($object->first_name),
            Name::from($object->last_name),
            EmailAddress::from($object->email_address),
            UserRoleType::from($object->role),
            UserStatusType::from($object->status),
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
        EmailAddress    $emailAddress,
        UserRoleType    $role,
    ): self
    {
        return new self(
            null,
            $firstName,
            $lastName,
            $emailAddress,
            $role,
            self::$defaultStatus,
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

    public function getEmailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(EmailAddress $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    public function getRole(): UserRoleType
    {
        return $this->role;
    }

    public function setRole(UserRoleType $role): void
    {
        $this->role = $role;
    }

    public function getStatus(): UserStatusType
    {
        return $this->status;
    }

    public function setStatus(UserStatusType $status): void
    {
        $this->status = $status;
    }

    #[ArrayShape([
        'id'            => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\UserId",
        'firstName'     => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\Name",
        'lastName'      => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\Name",
        'emailAddress'  => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\EmailAddress",
        'role'          => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\Type\UserRoleType",
        'status'        => "\Caerfyrddin\MerlinSyncServer\Shared\Domain\Type\UserStatusType",
        'createdAt'     => "\DateTime",
        'modifiedAt'    => "\DateTime|null",
    ])]
    public function jsonSerialize(): array
    {
        return [
            'id'            => $this->id,
            'firstName'     => $this->firstName,
            'lastName'      => $this->lastName,
            'emailAddress'  => $this->emailAddress,
            'role'          => $this->role,
            'status'        => $this->status,
            'createdAt'     => $this->createdAt,
            'modifiedAt'    => $this->modifiedAt,
        ];
    }
}