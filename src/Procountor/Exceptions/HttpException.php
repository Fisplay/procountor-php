<?php

namespace Procountor\Procountor\Exceptions;

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
}
