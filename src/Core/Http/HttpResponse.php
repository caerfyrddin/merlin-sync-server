<?php

namespace Caerfyrddin\MerlinSyncServer\Core\Http;

use JsonSerializable;

/**
 * Api response
 *
 * @package merlin-sync-server
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

class HttpResponse
{
    private int     $statusCode;
    private array   $headers;
    private string  $content;

    private static int $defaultStatusCode = 200;
    private static array $jsonHeader = [ 'Content-Type' => "application/json" ];

    public function __construct(string $content, int $statusCode = null, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode ?? self::$defaultStatusCode;
        $this->headers = $headers;
    }

    public static function json(JsonSerializable $content, int $statusCode = null, array $headers = []): self
    {
        $body = [
            'status'    => $statusCode ?? self::$defaultStatusCode,
            'content'   => $content,
        ];

        return new self(json_encode($body), $statusCode, array_merge_recursive($headers, self::$jsonHeader));
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function content(): string
    {
        return $this->content;
    }

}