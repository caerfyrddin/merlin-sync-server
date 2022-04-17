<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Api;

use Caerfyrddin\MerlinSyncServer\Core\Http\HttpHelper;
use JetBrains\PhpStorm\NoReturn;

/**
 * Api-related functionality and management
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class ApiManager
{

    public function call(Api $api): void
    {
        $requestDataInput = file_get_contents('php://input');
        $requestContent = json_decode($requestDataInput);

        $api->consume($requestContent);
    }

    /**
     * Generates an HTTP response with JSON data and an HTTP status code
     *
     * @param int $httpStatusCode HTTP status code
     * @param object $data Data to send in the response
     * @param array|null $messages Messages to send in the response
     */
    #[NoReturn]
    public static function apiRespond(
        int $httpStatusCode,
        mixed $data,
        ?array $messages = []
    ): void
    {
        HttpHelper::respondJson(
            $httpStatusCode,
            [
                'data' => $data,
                'messages' => $messages
            ]
        );
    }
}
