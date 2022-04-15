<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Helper;

/**
 * User helper
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class UserHelper
{

    /**
     * Generates a safe token
     */
    public static function generateToken(string $govId): string
    {
        return md5(uniqid($govId, true));
    }
}
