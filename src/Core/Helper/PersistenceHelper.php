<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Helper;

/**
 * Persistence helper
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class PersistenceHelper
{

    public static function tableName(object $object): string
    {
        $className = get_class($object);

        return $className::$tableName ??
            strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
    }
}
