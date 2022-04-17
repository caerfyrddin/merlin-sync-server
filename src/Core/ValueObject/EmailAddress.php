<?php

namespace Caerfyrddin\MerlinSyncServer\Core\ValueObject;

use JsonSerializable;

/**
 * Email address value object
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

final class EmailAddress implements JsonSerializable
{
    private string $emailAddress;

    private function __construct(string $email)
    {
        $this->setEmailAddress($email);
    }

    public static function from(string $email): self
    {
        return new self($email);
    }

    public function jsonSerialize(): string
    {
        return $this->emailAddress;
    }

    public function email(): string
    {
        return $this->emailAddress;
    }

    public function __toString(): string
    {
        return $this->emailAddress;
    }

    private function setEmailAddress(string $emailAddress): void
    {
        // FIXME Assertion::email($emailAddress);
        $this->emailAddress = $emailAddress;
    }
}
