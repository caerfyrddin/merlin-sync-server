<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Attribute;

use Attribute;
use Caerfyrddin\MerlinSyncServer\Core\Exception\AggregateNotRetrievedException;

/**
 * Denotes an aggregate's property as required (not nullable) if the prior is not in
 * AggregatePersistenceStatusType::Placeholder status.
 *
 * For future implementation.
 *
 * @ throws an exception if the conditions are met
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

#[Attribute(Attribute::TARGET_PROPERTY)]
class Required
{

}