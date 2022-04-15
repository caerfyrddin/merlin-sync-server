<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Api;

/**
 * API model
 *
 * Forms must extend this class, which also provides handling functionality.
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

abstract class Api
{

    abstract public function consume(object $requestContent): void;
}