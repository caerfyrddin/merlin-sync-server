<?php

namespace Juancrrn\Carrier\Common\Controller;

use Carrier\Common\App;
use Carrier\Common\Controller\Controller;
use Carrier\Common\Controller\RouteGroup;

use Juancrrn\Carrier\Common\View\Auth\LoginView;
use Juancrrn\Carrier\Common\View\Auth\PasswordResetProcessView;
use Juancrrn\Carrier\Common\View\Auth\PasswordResetRequestView;
use Juancrrn\Carrier\Common\View\Home\DashboardView;
use Juancrrn\Carrier\Common\View\Home\HomeView;
use Juancrrn\Carrier\Domain\View\Error\Error404View;

/**
 * Anyone route group
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class AnyoneRouteGroup implements RouteGroup
{

    private $controllerInstance;

    public function __construct(Controller $controllerInstance)
    {
        $this->controllerInstance = $controllerInstance;
    }

    public function runAll(): void
    {
        $viewManager = App::getSingleton()->getViewManagerInstance();

        // Home page
        $this->controllerInstance->get('/?', function () use ($viewManager) {
            $sessionManager = App::getSingleton()->getSessionManagerInstance();

            if ($sessionManager->isLoggedIn()) {
                $viewManager->render(new DashboardView);
            } else {
                $viewManager->render(new HomeView);
            }
        });

        // Login
        $this->controllerInstance->get('/auth/login/', function () use ($viewManager) {
            $viewManager->render(new LoginView);
        });

        // Login (form POST)
        $this->controllerInstance->post('/auth/login/', function () use ($viewManager) {
            $viewManager->render(new LoginView);
        });

        // Password reset request
        $this->controllerInstance->get('/auth/reset/request/', function () use ($viewManager) {
            $viewManager->render(new PasswordResetRequestView);
        });

        // Password reset request (form POST)
        $this->controllerInstance->post('/auth/reset/request/', function () use ($viewManager) {
            $viewManager->render(new PasswordResetRequestView);
        });

        // Password reset process
        $this->controllerInstance->get('/auth/reset/process/([0-9a-zA-Z]*)', function ($token) use ($viewManager) {
            $viewManager->render(new PasswordResetProcessView($token));
        });

        // Password reset process (form POST)
        $this->controllerInstance->post('/auth/reset/process/([0-9a-zA-Z]*)', function ($token) use ($viewManager) {
            $viewManager->render(new PasswordResetProcessView($token));
        });
    }

    public function runDefault(): void
    {
        $viewManager = App::getSingleton()->getViewManagerInstance();

        // Default route (error 404)
        $this->controllerInstance->default(function () use ($viewManager) {
            $viewManager->render(new Error404View);
        });
    }
}