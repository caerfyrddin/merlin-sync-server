<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Data;

use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AggregateId;
use DateTime;

/**
 * Time traceable base class
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class TimeTraceable
{

    protected DateTime $createdAt;
    protected ?DateTime $modifiedAt;

    public function __construct(
        DateTime $createdAt = null,
        ?DateTime $modifiedAt = null
    )
    {
        $this->createdAt = $createdAt;
        $this->modifiedAt = $modifiedAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setModifiedAt(DateTime $modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    public function getModifiedAt(): DateTime
    {
        return $this->modifiedAt;
    }
}