<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Domain\Type;

/**
 * Photo origin client type
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

enum PhotoOriginClientType: string
{

    case Mobile = 'photo_origin_client_mobile';
    case Web = 'photo_origin_client_web';
}
