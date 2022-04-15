<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Type;

/**
 * Photo processing status type
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

enum PhotoProcessingStatusType: string
{

    case Pending = 'photo_processing_status_pending';
    case Ongoing = 'photo_processing_status_ongoing';
    case Processed = 'photo_processing_status_processed';
}
