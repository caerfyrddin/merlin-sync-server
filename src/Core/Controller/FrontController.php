<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Controller;

use Caerfyrddin\MerlinSyncServer\Core\Helper\CommonHelper;
use Caerfyrddin\MerlinSyncServer\Core\Http\HttpHelper;
use Caerfyrddin\MerlinSyncServer\Core\Http\HttpMethod;

/**
 * Handles HTTP requests (front controller pattern)
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class FrontController
{

    private string $pathBase;

    private array $controllers;

    public function __construct(string $pathBase)
    {
        $this->pathBase = $pathBase;
    }

    public function initialize(array $controllers): void
    {
        foreach ($controllers as $controller) {
            $this->controllers[] = new $controller();
        }
    }

    public function control(): void
    {
        foreach ($this->controllers as $controller) {
            $controller->run();
        }

        $this->default(function () {});
    }

    /** Processes any request regardless of the method */
    public function any(string $route, string $endpointClass): void
    {
        $this->processRequest($route, $endpointClass);
    }

    /** Processes a GET request */
    public function get(string $route, string $endpointClass): void
    {
        if (HttpHelper::isRequestMethod(HttpMethod::GET))
            $this->processRequest($route, $endpointClass);
    }

    /** Processes a POST request */
    public function post(string $route, string $endpointClass): void
    {
        if (HttpHelper::isRequestMethod(HttpMethod::POST))
            $this->processRequest($route, $endpointClass);
    }

    /** Processes a PUT request */
    public function put(string $route, string $endpointClass): void
    {
        if (HttpHelper::isRequestMethod(HttpMethod::PUT))
            $this->processRequest($route, $endpointClass);
    }

    /** Processes a DELETE request */
    public function delete(string $route, string $endpointClass): void
    {
        if (HttpHelper::isRequestMethod(HttpMethod::DELETE))
            $this->processRequest($route, $endpointClass);
    }

    /** Processes a PATCH request */
    public function patch(string $route, string $endpointClass): void
    {
        if (HttpHelper::isRequestMethod(HttpMethod::PATCH))
            $this->processRequest($route, $endpointClass);
    }

    /** Processes a generic request */
    public function processRequest(string $route, string $endpointClass): void
    {
        $matches = [];

        if (HttpHelper::matchesRequestUri($this->pathBase, $route, $matches)) {
            call_user_func_array(new $endpointClass(), $matches);

            // TODO Process response or exception

            die();
        }
    }

    /**
     * Runs when no other route has been processed
     */
    public function default(callable $handler): void
    {
        http_response_code(404);

        echo call_user_func($handler);
    }
}