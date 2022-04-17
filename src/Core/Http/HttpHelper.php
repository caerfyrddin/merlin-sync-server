<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Http;

use JetBrains\PhpStorm\NoReturn;

/**
 * HTTP utils
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class HttpHelper
{

    /**
     * Redirecciona a una URL y detiene la ejecución del script.
     */
    #[NoReturn]
    public static function redirect(string $url): void
    {
        header('Location: ' . $url);
        die();
    }

    /**
     * Devuelve el método de petición HTTP.
     *
     * @return string
     */
    public static function getRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Comprueba si el método de petición HTTP es el especificado.
     *
     * @param HttpMethod $testRequestMethod
     *
     * @return bool
     */
    public static function isRequestMethod(HttpMethod $testRequestMethod): bool
    {
        return $_SERVER['REQUEST_METHOD'] == $testRequestMethod->value;
    }

    /**
     * Comprueba si una cadena de texto (ruta) coincide con la URI de la
     * petición HTTP.
     *
     * @param string $urlBase   Base de la URL.
     * @param string $testRoute Ruta a comprobar. Pueden especificarse
     *                          parámetros o variables mediante grupos en la
     *                          expresión regular, utilizando paréntesis.
     * @param array $matches    Array en el que depositar los resultados de los
     *                          parámetros, si se especificaron y se encontró
     *                          alguno.
     *
     * @return bool             True si coincide, false en caso contrario.
     */
    public static function matchesRequestUri(string $urlBase, string $testRoute, array &$matches): bool
    {
        /**
         * # al principio y al final son delimitadores de la expresión regular.
         *
         * ^ y $ son metacaracteres de expresiones regulares que se utilizan como
         * anclas de inicio y fin, respectivamente.
         */

        $getParamsRegEx = '(\?.*)?';

        if (preg_match('#^' . $urlBase . $testRoute . $getParamsRegEx . '$#', $_SERVER['REQUEST_URI'], $matches) == 1) {
            array_shift($matches);
            $matches = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Generates an HTTP response with a JSON-encoded data and an HTTP status
     * code, and stops script execution
     *
     * @param array $data     Data to send in the response
     * @param int   $httpCode HTTP status code
     */
    #[NoReturn]
    public static function respondJson(int $httpCode, array $data): void
    {
        http_response_code($httpCode);

        header('Content-Type: application/json; charset=utf-8');

        // This should be the only echo in all the code
        echo json_encode($data);

        // Nothing else should be sent
        die();
    }

    /**
     * Responds with an HTTP 200 OK and message
     *
     * @param array $data Data to send
     */
    #[NoReturn]
    public static function respondJsonOk(array $data): void
    {
        $okData = array(
            'status' => 'ok',
        );

        $responseData = array_merge($okData, $data);

        self::respondJson(200, $responseData);
    }
}