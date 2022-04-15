<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Type;

/**
 * User status type
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

enum UserStatusType: string
{

    case Disabled = 'user_status_disabled';
    case Enabled = 'user_status_enabled';
}
