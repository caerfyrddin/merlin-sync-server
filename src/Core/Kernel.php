<?php

declare(strict_types = 1);

namespace Caerfyrddin\MerlinSyncServer\Core;

use Caerfyrddin\MerlinSyncServer\Core\ValueObject\Name;
use Caerfyrddin\MerlinSyncServer\Core\ValueObject\DirectoryPath;
use Caerfyrddin\MerlinSyncServer\Core\ValueObject\Url;
use Exception;

require_once __DIR__ . '/../../config/config.php';

/**
 * App initialization
 *
 * TODO Check that config.php file exists.
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */
class Kernel
{

    public static function run(): void
    {
        if (MERLIN_DEV_MODE) {
            ini_set('display_errors', 'On');
            error_reporting(E_ALL);
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }

        ini_set('default_charset', 'UTF-8');
        setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
        date_default_timezone_set('Europe/Madrid');

        App::initialize(
            [
                'host' => MERLIN_DB_HOST,
                'user' => MERLIN_DB_USER,
                'password' => MERLIN_DB_PASSWORD,
                'name' => MERLIN_DB_NAME
            ],
            DirectoryPath::from(MERLIN_ROOT),
            Url::from(MERLIN_URL),
            DirectoryPath::from(MERLIN_PATH_BASE),
            Name::from(MERLIN_NAME),
            MERLIN_CONTROLLERS,
            MERLIN_DEV_MODE,
            MERLIN_ADDITIONAL_SETTINGS
        );

        App::app()->frontController()->control();
    }
}
