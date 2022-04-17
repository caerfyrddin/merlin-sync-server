<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Data;

use Caerfyrddin\MerlinSyncServer\Core\Exception\AggregateNotPersistedException;
use Caerfyrddin\MerlinSyncServer\Core\Exception\AggregateNotRetrievedException;
use Caerfyrddin\MerlinSyncServer\Core\Exception\AggregateToManyNotPopulatedException;
use Caerfyrddin\MerlinSyncServer\Core\Exception\ForeignAggregateNotRetrievedException;
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

abstract class Aggregate
{

    protected AggregatePersistenceStatusType $persistenceStatus = AggregatePersistenceStatusType::NotPersistedNew;

    protected ?AggregateId  $id;
    protected ?DateTime     $createdAt;
    protected ?DateTime     $modifiedAt;

    #[Pure]
    public function __construct(
        ?AggregateId    $id,
        ?DateTime       $createdAt,
        ?DateTime       $modifiedAt
    )
    {
        $this->id           = $id;
        $this->createdAt    = $createdAt;
        $this->modifiedAt   = $modifiedAt;
    }

    public abstract static function fromIdAsPlaceholder($id): static;

    public function setPersistenceStatusAsPlaceholder(): void
    {
        $this->persistenceStatus = AggregatePersistenceStatusType::Placeholder;
    }

    /**
     * @throws AggregateNotPersistedException
     */
    public function getId(): ?AggregateId
    {
        if ($this->persistenceStatus === AggregatePersistenceStatusType::NotPersistedNew)
            throw new AggregateNotPersistedException("Aggregate has not been persisted and thus it does not have an id assigned.");

        return $this->id;
    }

    public function setId(?AggregateId $id): void
    {
        $this->id = $id;
    }

    public function getCreatedAt(): ?DateTime
    {
        $this->checkNotInPlaceholderStatus();
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getModifiedAt(): ?DateTime
    {
        $this->checkNotInPlaceholderStatus();
        return $this->modifiedAt;
    }

    public function setModifiedAt(?DateTime $modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @throws AggregateNotRetrievedException
     */
    protected function checkNotInPlaceholderStatus(): void
    {
        if ($this->persistenceStatus == AggregatePersistenceStatusType::Placeholder)
            throw new AggregateNotRetrievedException("Aggregate is in placeholder status and thus its properties are not available.");
    }

    /**
     * @throws ForeignAggregateNotRetrievedException
     */
    protected function checkForeignAggregateRetrieved(?Aggregate $aggregate): void
    {
        $this->checkNotInPlaceholderStatus();

        if (! $aggregate)
            throw new ForeignAggregateNotRetrievedException("Aggregate is not in placeholder status but foreign aggregate has not been retrieved or injected.");
    }

    /**
     * @throws ForeignAggregateNotRetrievedException
     */
    protected function checkToManyPopulated(?array $array): void
    {
        $this->checkNotInPlaceholderStatus();

        if (! $array)
            throw new AggregateToManyNotPopulatedException("Aggregate is not in placeholder status but one or many to many relationship entities have not been populated.");
    }
}
