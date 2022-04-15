<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Helper;

use JetBrains\PhpStorm\NoReturn;

/**
 * Common utils
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class CommonHelper
{

    /**
     * Quick debug function
     */
    #[NoReturn]
    public static function dd($var)
    {
        $bt = debug_backtrace();

        echo 'dd(): ' . $bt[1]['class'] . '::' . $bt[1]['function'] . '() @ ' . $bt[1]['file'] . ':' . $bt[1]['line'] . "\n";

        var_dump($var);

        die();
    }

    /**
     * Quick debug function with file name and line number
     */
    #[NoReturn]
    public static function ddl(?string $message, mixed $var)
    {
        $bt = debug_backtrace();
        $caller = array_shift($bt);

        echo 'ddl(): ' . $caller['file'] . ':' . $caller['line'] . "\n";

        if (! is_null($message)) {
            echo $message . "\n";
        }

        if (! is_null($var)) {
            var_dump($var);
        }

        die();
    }
}