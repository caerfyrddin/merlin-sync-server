<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Data;

use Caerfyrddin\MerlinSyncServer\Core\Exception\AggregateNotPersistedException;
use Caerfyrddin\MerlinSyncServer\Shared\Domain\ValueObject\AggregateId;
use DateTime;
use JetBrains\PhpStorm\Pure;

/**
 * Aggregate base class
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class Aggregate extends TimeTraceable
{

    protected ?AggregateId $id;

    public function __construct(
        ?AggregateId $id,
        ?DateTime   $createdAt,
        ?DateTime   $modifiedAt
    )
    {
        parent::__construct($createdAt, $modifiedAt);
        $this->id = $id;
    }

    public function setId(AggregateId $id): void
    {
        $this->id = $id;
    }

    /**
     * @throws AggregateNotPersistedException
     */
    public function getId(): AggregateId
    {
        if (! $this->id)
            throw new AggregateNotPersistedException("Aggregate has not been persisted and thus does not have an id assigned.");

        return $this->id;
    }
}