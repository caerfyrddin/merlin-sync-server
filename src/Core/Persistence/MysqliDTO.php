<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Persistence;

/**
 * MySQLi DTO interface
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

interface MysqliDTO
{

    public static function fromMysqliObject(object $object): static;
}
