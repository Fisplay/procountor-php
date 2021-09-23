<?php

namespace Procountor\Procountor\Interfaces;

interface LoggerInterface
{
    public function log(
        string $requestUrl,
        string $requestType,
        string $requestHeaders,
        string $requestBody,
        string $responseStatusCode,
        string $responseHeaders,
        string $responseBody
    );
}
