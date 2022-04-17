<?php

namespace Caerfyrddin\MerlinSyncServer\Core;

use Caerfyrddin\MerlinSyncServer\Core\Api\ApiManager;
use Caerfyrddin\MerlinSyncServer\Core\Controller\FrontController;
use Caerfyrddin\MerlinSyncServer\Core\Session\SessionManager;
use Caerfyrddin\MerlinSyncServer\Core\ValueObject\DirectoryPath;
use Caerfyrddin\MerlinSyncServer\Core\ValueObject\Name;
use Caerfyrddin\MerlinSyncServer\Core\ValueObject\Url;
use Exception;
use mysqli;
use mysqli_sql_exception;

/**
 * App initialization and general functionality
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class App
{

    private static ?App          $instance = null;

    private SessionManager      $sessionManagerInstance;
    private FrontController     $frontControllerInstance;
    private ApiManager          $apiManagerInstance;

    private array               $databaseConnectionCredentials;
    private ?mysqli             $databaseConnectionInstance;

    private DirectoryPath       $rootDirectoryPath;
    private Url                 $rootUrl;
    private DirectoryPath       $controllerBasePath;
    private Name                $name;

    private bool                $inDevMode;

    private array               $additionalSettings;

    private function __construct(
        SessionManager      $sessionManagerInstance,
        FrontController     $frontControllerInstance,
        ApiManager          $apiManagerInstance,

        array               $databaseConnectionCredentials,

        DirectoryPath       $rootDirectoryPath,
        Url                 $rootUrl,
        DirectoryPath       $controllerBasePath,
        Name                $name,

        bool                $inDevMode,

        array               $additionalSettings,
    )
    {
        $this->sessionManagerInstance           = $sessionManagerInstance;
        $this->frontControllerInstance          = $frontControllerInstance;
        $this->apiManagerInstance               = $apiManagerInstance;

        $this->databaseConnectionCredentials    = $databaseConnectionCredentials;
        $this->databaseConnectionInstance       = null;

        $this->rootDirectoryPath                = $rootDirectoryPath;
        $this->rootUrl                          = $rootUrl;
        $this->controllerBasePath               = $controllerBasePath;
        $this->name                             = $name;

        $this->inDevMode                        = $inDevMode;

        $this->additionalSettings               = $additionalSettings;
    }

    /** @throws Exception */
    public function __clone()
    {
        throw new Exception("Cloning not allowed.");
    }

    /** @throws Exception */
    public function __sleep()
    {
        throw new Exception("Serializing not allowed.");
    }

    /** @throws Exception */
    public function __wakeup()
    {
        throw new Exception("Deserializing not allowed.");
    }

    public static function app(): self
    {
        return self::$instance;
    }

    /**
     * Initialize the app instance
     */
    public static function initialize(
        array           $databaseConnectionCredentials,

        DirectoryPath   $rootDirectoryPath,
        Url             $rootUrl,
        DirectoryPath   $controllerBasePath,
        Name            $name,

        array           $controllers,

        bool            $inDevMode,

        array           $additionalSettings,
    ): void
    {
        self::$instance = new self(
            new SessionManager(),
            new FrontController($controllerBasePath),
            new ApiManager(),

            $databaseConnectionCredentials,

            $rootDirectoryPath,
            $rootUrl,
            $controllerBasePath,
            $name,

            $inDevMode,

            $additionalSettings
        );

        self::$instance->frontController()->initialize($controllers);
    }

    /** @throws Exception */
    private function initializeDatabaseConnectionInstance(): void
    {
        $host       = $this->databaseConnectionCredentials['host'];
        $user       = $this->databaseConnectionCredentials['user'];
        $password   = $this->databaseConnectionCredentials['password'];
        $name       = $this->databaseConnectionCredentials['name'];

        try {
            $this->databaseConnectionInstance = new mysqli($host, $user, $password, $name);
        } catch (mysqli_sql_exception $e) {
            throw new Exception('Error connecting to the database.', 0, $e);
        }

        try {
            $this->databaseConnectionInstance->set_charset("utf8mb4");
        } catch (mysqli_sql_exception $e) {
            throw new Exception('Error setting up database encoding.', 1, $e);
        }
    }

    /** @throws Exception */
    public function db(): mysqli
    {
        if (! $this->databaseConnectionInstance)
            $this->initializeDatabaseConnectionInstance();
        return $this->databaseConnectionInstance;
    }

    public function sessionManager(): SessionManager
    {
        return $this->sessionManagerInstance;
    }

    public function frontController(): FrontController
    {
        return $this->frontControllerInstance;
    }

    public function apiManager(): ApiManager
    {
        return $this->apiManagerInstance;
    }

    public function rootDirectoryPath(): DirectoryPath
    {
        return $this->rootDirectoryPath;
    }

    public function rootUrl(): Url
    {
        return $this->rootUrl;
    }

    public function controllerBasePath(): DirectoryPath
    {
        return $this->controllerBasePath;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function isInDevMode(): bool
    {
        return $this->inDevMode;
    }

    public function additionalSettings(): array
    {
        return $this->additionalSettings;
    }
}
