<?php

namespace Caerfyrddin\MerlinSyncServer\Shared\Infrastructure\Delivery\Controller;

use Caerfyrddin\MerlinSyncServer\Core\Api\ApiManager;
use Caerfyrddin\MerlinSyncServer\Core\App;
use Caerfyrddin\MerlinSyncServer\Core\Controller\Controller;
use Caerfyrddin\MerlinSyncServer\Core\Controller\FrontController;
use Caerfyrddin\MerlinSyncServer\Shared\Infrastructure\Delivery\Rest\User\RetrieveUserEndpoint;
use JetBrains\PhpStorm\Pure;

/**
 * Public controller
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class PublicController implements Controller
{

    /**
     * @var FrontController Autowired on construction via the app's singleton instance.
     */
    private FrontController $frontController;

    /**
     * @var ApiManager Autowired on construction via the app's singleton instance.
     */
    private ApiManager $apiManager;

    #[Pure]
    public function __construct()
    {
        $this->frontController = App::app()->frontController();
    }

    public function run(): void
    {
        $this->frontController->get('/users/(?<id>[0-9]+)', RetrieveUserEndpoint::class);
    }
}