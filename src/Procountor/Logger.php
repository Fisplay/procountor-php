<?php

namespace Procountor;

use Procountor\Interfaces\LoggerInterface;

class Logger implements LoggerInterface
{
	public function log(
		string $requestUrl,
		string $requestType,
		string $requestHeaders,
		string $requestBody,
		string $responseStatusCode,
		string $responseHeaders,
		string $responseBody)
	{

	}
}
