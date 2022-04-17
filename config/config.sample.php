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
const MERLIN_DB_HOST        = "localhost";
const MERLIN_DB_USER        = "";
const MERLIN_DB_PASSWORD    = "";
const MERLIN_DB_NAME        = "";

/**
 * Root directory, URL, path and app name
 */
const MERLIN_ROOT           = __DIR__ . "/../";
const MERLIN_PORT           = 49156;
const MERLIN_URL            = "http://sync.merlin.local:" . MERLIN_PORT;
const MERLIN_PATH_BASE      = "";
const MERLIN_NAME           = "Merlin Sync Server";

/**
 * Registered controllers
 */
const MERLIN_CONTROLLERS    = [
    "\Caerfyrddin\MerlinSyncServer\Shared\Infrastructure\Delivery\Controller\PublicController",
    "\Caerfyrddin\MerlinSyncServer\Shared\Infrastructure\Delivery\Controller\NotAuthenticatedController",
    "\Caerfyrddin\MerlinSyncServer\Shared\Infrastructure\Delivery\Controller\AuthenticatedController",
];

/**
 * Dev mode
 */
const MERLIN_DEV_MODE       = true;

/**
 * Additional settings
 */
const MERLIN_ADDITIONAL_SETTINGS = [];