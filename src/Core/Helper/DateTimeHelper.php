<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Helper;

use DateTime;

/**
 * Date and time helper
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class DateTimeHelper
{

    /**
     * @var string Standard MySQL DATETIME format
     */
    public const MYSQL_DATETIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @var string Standard MySQL DATE format
     */
    public const MYSQL_DATE_FORMAT = 'Y-m-d';

    /**
     * @var string Standard human-readable Spanish DATETIME format
     */
    public const HUMAN_DATETIME_FORMAT_ES_ES = 'j \d\e F \d\e\l Y \a \l\a\s H:i';

    /**
     * @var string Standard human-readable Spanish DATETIME format for strftime
     */
    public const HUMAN_DATETIME_FORMAT_ES_ES_STRF = '%e de %B de %Y a las %H:%M';

    /**
     * @var string Standard human-readable Spanish DATE format
     */
    public const HUMAN_DATE_FORMAT_ES_ES = 'j \d\e F \d\e\l Y';

    /**
     * @var string Standard human-readable Spanish DATE format for strftime
     */
    public const HUMAN_DATE_FORMAT_ES_ES_STRF = '%e de %B de %Y';

    public static function fromMysqliDateTime(?string $time): ?DateTime
    {
        return ! $time ? null :
            DateTime::createFromFormat(
                self::MYSQL_DATETIME_FORMAT,
                $time
            );
    }
}