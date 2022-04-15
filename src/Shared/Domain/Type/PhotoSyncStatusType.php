<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Type;

/**
 * Photo sync status type
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

enum PhotoSyncStatusType: string
{

    case Pending = 'photo_sync_status_pending';
    case Ongoing = 'photo_sync_status_ongoing';
    case Synced = 'photo_sync_status_synced';
}
