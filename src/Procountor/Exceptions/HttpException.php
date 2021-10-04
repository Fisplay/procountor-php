<?php

namespace Procountor\Procountor\Exceptions;

use Procountor\Helpers\Http;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

/**
 * class HttpException
 *
 * Generic base Exception class for all HTTP exceptions.
 *
 * @method int getCode() Returns the original HTTP Status Code
 *
 * @package Procountor\Procountor\Exceptions
 */
abstract class HttpException extends RuntimeException
{

    protected const MESSAGE = 'Request failed.';


    public function __construct(ResponseInterface $response, Throwable $previous = null)
    {
        $this->respone = $response;
        parent::__construct(static::MESSAGE, $response->getStatusCode(), $previous);
    }

    /**
     * Get the response body. If Content-Type is set to JSON,
     * returns parsed object.
     *
     * @return string|object|array
     */
    public function responseBody()
    {
        if (Http::isJson($this->response->getHeader('Content-Type')[0] ?? null)) {
            try {
                return json_decode($this->response->getBody()->getContents());
            } catch (Throwable $e) {
                unset($e); // noop, return the string body
            }
        }
        return $this->response->getBody()->getContents();
    }
}
