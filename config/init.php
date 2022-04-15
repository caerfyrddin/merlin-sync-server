<?php

/**
 * App initialization
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

/**
 * Enable PHP strict typing
 */
declare(strict_types = 1);

/**
 * Load settings file
 */
require_once __DIR__ . '/config.php';

/**
 * Enable error reporting when in dev mode
 */
if (CARRIER_DEV_MODE) {
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
}

/**
 * Setup encoding and timezone
 */
ini_set('default_charset', 'UTF-8');
setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
date_default_timezone_set('Europe/Madrid');

/**
 * Quick debug function
 *
function dd($var)
{
    $bt = debug_backtrace();

    echo 'dd(): ' . $bt[1]['class'] . '::' . $bt[1]['function'] . '() @ ' . $bt[1]['file'] . ':' . $bt[1]['line'] . "\n";

    var_dump($var);

    die();
}

/**
 * Quick debug function with file name and line number
 *
function ddl(?string $message, mixed $var)
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
}*/

/**
 * Load Composer dependencies and app namespace
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Initialize app instance
 */
$app = Juancrrn\Carrier\Common\App::getSingleton();

$app->init(
    [
        'host' => CARRIER_DB_HOST,
        'user' => CARRIER_DB_USER,
        'password' => CARRIER_DB_PASSWORD,
        'name' => CARRIER_DB_NAME
    ],

    CARRIER_ROOT,
    CARRIER_URL,
    CARRIER_PATH_BASE,
    CARRIER_NAME,

    CARRIER_DEV_MODE,

    [
        'enable'            => CARRIER_EMAIL_ENABLE,
        'smtp_host'         => CARRIER_EMAIL_SMTP_HOST,
        'smtp_port'         => CARRIER_EMAIL_SMTP_PORT,
        'smtp_user'         => CARRIER_EMAIL_SMTP_USER,
        'smtp_password'     => CARRIER_EMAIL_SMTP_PASSWORD,
        'no_reply'          => CARRIER_EMAIL_NO_REPLY,
        'reply_to'          => CARRIER_EMAIL_REPLY_TO,
        'dkim_domain'       => CARRIER_EMAIL_DKIM_DOMAIN,
        'dkim_selector'     => CARRIER_EMAIL_DKIM_SELECTOR,
        'dkim_private_key'  => CARRIER_EMAIL_DKIM_PRIVATE_KEY,
        'dkim_private_key_passphrase' => CARRIER_EMAIL_DKIM_PRIVATE_KEY_PASSPHRASE
    ],

    [
        // Additional settings
    ]
);