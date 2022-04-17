<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Api;

use Caerfyrddin\MerlinSyncServer\Core\Action\Action;
use Caerfyrddin\MerlinSyncServer\Core\Http\HttpRequest;
use Caerfyrddin\MerlinSyncServer\Core\Http\HttpResponse;

abstract class ApiEndpoint
{

    private static string $handlerSuffix = "Handler";

    //abstract public function __invoke(HttpRequest $request): HttpResponse;

    protected function act(Action $action): HttpResponse
    {
        $handlerClass = $action::class . self::$handlerSuffix;
        return (new $handlerClass())($action);
    }
}
