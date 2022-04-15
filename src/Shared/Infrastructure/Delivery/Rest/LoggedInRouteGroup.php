<?php

namespace Juancrrn\Carrier\Common\Controller;

use Carrier\Common\App;
use Carrier\Common\Controller\Controller;
use Carrier\Common\Controller\RouteGroup;

use Juancrrn\Carrier\Domain\StaticForm\Auth\LogoutForm;
use Juancrrn\Lyra\Common\View\Self\ProfileView;

/**
 * Logged-in route group
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */
class LoggedInRouteGroup implements RouteGroup
{

    private $controllerInstance;

    public function __construct(Controller $controllerInstance)
    {
        $this->controllerInstance = $controllerInstance;
    }

    public function runAll(): void
    {
        $viewManager = App::getSingleton()->getViewManagerInstance();

        // Logout (form POST)
        $this->controllerInstance->post('/auth/logout/', function () {
            (new LogoutForm('/auth/logout/'))->handle();
        });

        // Profile
        $this->controllerInstance->get('/self/profile/', function () use ($viewManager) {
            $viewManager->render(new ProfileView);
        });
    }
}