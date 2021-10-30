<?php

use Mockery\MockInterface;
use Procountor\Helpers\Http;
use Procountor\Procountor\Client;
use Procountor\Procountor\Exceptions\ValidationException;
use Procountor\Tests\ApiTestCase;
use Procountor\Tests\TestDoubles\Invoice;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

test('HTTP400 response throws ValidationException', function () {
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
            $this->jsonResponse(200, ['access_token' => 'qwertyuiop', 'expires_in' => 123456]),
            // second request fetches resource
            $this->jsonResponse(400, ['errors' => [['status' => 400, 'message' => $this->faker->text()]]])
        )
        ->mock();
    /** @var ClientInterface $httpClient */

    /** @var Client $client */
    $client = $this->createClient(
        logger: $logger,
        httpClient: $httpClient,
    );

    $request = $client->createRequest(Http::POST, Client::RESOURCE_INVOICE, new Invoice());
    $client->request($request);
})
    ->throws(ValidationException::class)
    ->group('errors');


test('querying missing item should throw', function () {
    expect(true)->toBeTrue();
})->skip('Test incomplete');
