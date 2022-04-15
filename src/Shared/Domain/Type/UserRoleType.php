<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Type;

/**
 * User role type
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

enum UserRoleType: string
{

    case User = 'user_role_user';
    case Admin = 'user_role_admin';
}
