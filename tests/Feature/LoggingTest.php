<?php

use Mockery\MockInterface;
use Procountor\Helpers\Http;
use Procountor\Procountor\Client;
use Procountor\Tests\ApiTestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;


it('calls logger on request', function () {

    /** @var ApiTestCase $this */

    /** @var MockInterface $logger */
    $logger = mock(LoggerInterface::class);
    $logger = $logger->shouldReceive('info')
        ->with(Mockery::capture($logMessage), Mockery::capture($logContext))
        ->times(2) // 1. request token 2. make the api call
        ->mock();
    /** @var LoggerInterface $logger */

    /** @var MockInterface $httpClient */
    $httpClient = mock(ClientInterface::class);
    $httpClient = $httpClient->shouldReceive('sendRequest')
        ->with(Mockery::type(RequestInterface::class))
        ->andReturn(
            // first request creates access token
            $this->jsonResponse(200,['access_token' => 'qwertyuiop', 'expires_in' => 123456]),
            // second request fetches resource
            $this->createResponse(200)
        )
        ->mock();
    /** @var ClientInterface $httpClient */

    /** @var Client $client */
    $client = $this->createClient(
        logger: $logger,
        httpClient: $httpClient,
    );

    $request = $client->createRequest(Http::GET, Client::RESOURCE_INVOICE);
    $client->request($request);

})->group('logging');
