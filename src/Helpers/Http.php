<?php

namespace Procountor\Helpers;


abstract class Http
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';
    public const BAD_REQUEST = 400;


    public static function isJson(?string $header = null): bool
    {
        if (is_null($header)) {
            return false;
        }
        return substr($header, 0, 16)  === 'application/json';
    }
}
