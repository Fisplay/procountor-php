<?php

namespace Procountor\Helpers;

use Psr\Http\Message\ResponseInterface;
use Throwable;

abstract class Http
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';
    public const BAD_REQUEST = 400;


    /**
     * Test if given header value is set to application/json.
     * Ignores charset as valid JSON should only contain UTF-8.
     *
     * @param null|string $header
     * @return bool
     */
    public static function isJson(?string $header = null): bool
    {
        if (is_null($header)) {
            return false;
        }
        return substr($header, 0, 16)  === 'application/json';
    }

    /**
     * Get the response body. If Content-Type is set to JSON,
     * returns parsed object.
     *
     * @return string|object|array
     */
    public static function responseBody(ResponseInterface $response)
    {
        if (self::isJson($response->getHeader('Content-Type')[0] ?? null)) {
            try {
                return json_decode($response->getBody()->getContents());
            } catch (Throwable $e) {
                unset($e); // noop, return the string body
            }
        }
        return $response->getBody()->getContents();
    }
}
