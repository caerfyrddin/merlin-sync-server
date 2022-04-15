<?php

namespace Caerfyrddin\MerlinSyncServer\Core;

/**
 * Allowed HTTP methods
 *
 * Taken from https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods.
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

enum HttpMethod: string
{

    /**
     * The GET method requests a representation of the specified resource.
     * Requests using GET should only retrieve data.
     */
    case GET = 'GET';

    /**
     * The POST method is used to submit an entity to the specified resource,
     * often causing a change in state or side effects on the server.
     */
    case POST = 'POST';

    /**
     * The PUT method replaces all current representations of the target
     * resource with the request payload.
     */
    case PUT = 'PUT';

    /**
     * The DELETE method deletes the specified resource.
     */
    case DELETE = 'DELETE';

    /**
     * The PATCH method is used to apply partial modifications to a resource.
     */
    case PATCH = 'PATCH';
}