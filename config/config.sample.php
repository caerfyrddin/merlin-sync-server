<?php

/**
 * App settings
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

/**
 * Database host, user, password and name
 */
define('CARRIER_DB_HOST',       'localhost');
define('CARRIER_DB_USER',       '');
define('CARRIER_DB_PASSWORD',   '');
define('CARRIER_DB_NAME',       '');

/**
 * Root directory, URL, path and app name
 */
define('CARRIER_ROOT',          __DIR__ . '/../');
define('CARRIER_URL',           'https://');
define('CARRIER_PATH_BASE',     '');
define('CARRIER_NAME',          '');

/**
 * Dev mode
 */
define('CARRIER_DEV_MODE',      true);

/**
 * Email settings
 */
define('CARRIER_EMAIL_ENABLE',         false);
define('CARRIER_EMAIL_SMTP_HOST',      '');
define('CARRIER_EMAIL_SMTP_PORT',      '');
define('CARRIER_EMAIL_SMTP_USER',      '');
define('CARRIER_EMAIL_SMTP_PASSWORD',  '');
define('CARRIER_EMAIL_NO_REPLY',       '');
define('CARRIER_EMAIL_REPLY_TO',       '');
define('CARRIER_EMAIL_DKIM_DOMAIN',    '');
define('CARRIER_EMAIL_DKIM_SELECTOR',  '');
define('CARRIER_EMAIL_DKIM_PRIVATE_KEY', realpath(__DIR__ . '/email/dkim_private.pem'));
define('CARRIER_EMAIL_DKIM_PRIVATE_KEY_PASSPHRASE', '');