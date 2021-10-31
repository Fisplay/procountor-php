<?php

use Cache\Adapter\PHPArray\ArrayCachePool;
use Mockery\MockInterface;
use Procountor\Helpers\Http;
use Procountor\Procountor\Client;
use Procountor\Tests\ApiTestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;


it('returns access token and stores it in cache', function () {
    /** @var ApiTestCase $this */

    /** @var MockInterface $httpClient */
    $httpClient = mock(ClientInterface::class);
    $httpClient = $httpClient->shouldReceive('sendRequest')
        ->with(Mockery::type(RequestInterface::class))
        ->andReturn(
             // first request creates access token
            $this->jsonResponse(200, ['access_token' => 'qwertyuiop', 'expires_in' => 123456]),
            // second request fetches resource, this doesn't really matter. We just need something to trigger the access token fetching.
            $this->createResponse(200)
        )
        ->mock();
    /** @var ClientInterface $httpClient */

    $cache = new ArrayCachePool();

    /** @var Client $client */
    $client = $this->createClient(
        httpClient: $httpClient,
        cachePool: $cache,
    );

    $request = $client->createRequest(Http::GET, Client::RESOURCE_INVOICE);
    $client->request($request);

    $cacheItem = $cache->getItem($this->environment->getCacheKey());

    $this->assertTrue($cacheItem->isHit());
    $this->assertEquals('qwertyuiop', $cacheItem->get());

})->group('auth');


it('returns access token', function () {
    /** @var ApiTestCase $this */

    $cache = new ArrayCachePool();

    /** @var Client $client */
    $client = $this->createClient(cachePool: $cache);

    $request = $client->createRequest(Http::GET, Client::RESOURCE_INVOICE);
    $client->request($request);

    $cacheItem = $cache->getItem($this->environment->getCacheKey());

    $this->assertTrue($cacheItem->isHit());
    $this->assertNotNull($cacheItem->get());
    $this->assertMatchesRegularExpression('/^([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_\-\+\/=]*)$/', $cacheItem->get()); // make sure it looks like a JWT

})
    ->skip(fn() => !isset($_ENV['REAL_API_REQUESTS']))
    ->group('auth');
