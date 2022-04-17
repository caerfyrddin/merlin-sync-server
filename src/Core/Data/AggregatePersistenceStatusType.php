<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Data;

/**
 * Aggregate persistence status type
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

enum AggregatePersistenceStatusType
{

    /**
     * The aggregate has just been created in memory and has never been persisted before.
     */
    case NotPersistedNew;

    /**
     * The aggregate has not been retrieved, it is currently a placeholder with an id. In this status, it is disallowed
     * to access object properties.
     */
    case Placeholder;

    /**
     * The aggregate was persisted before but changes have been made, and are not present in the database yet.
     */
    case NotPersistedUpdated;

    /**
     * The aggregate is persisted and updated in the database.
     */
    case Persisted;
}