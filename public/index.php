<?php

require_once __DIR__ . '/../config/init.php';

use Juancrrn\Carrier\Common\App;
use Juancrrn\Carrier\Common\Controller\AnyoneRouteGroup;
use Juancrrn\Carrier\Common\Controller\LoggedInRouteGroup;

$controllerInstance = App::getSingleton()->getControllerInstance();

(new AnyoneRouteGroup($controllerInstance))->runAll();

(new LoggedInRouteGroup($controllerInstance))->runAll();

(new AnyoneRouteGroup($controllerInstance))->runDefault();