<?php

namespace Procountor\Procountor;

use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use Procountor\Procountor\Json\Builder;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;

class Client
{

    public const HTTP_GET = 'GET';
    public const HTTP_POST = 'POST';
    public const HTTP_PUT = 'PUT';
    public const HTTP_DELETE = 'DELETE';
    public const RESOURCE_ATTACHMENT = 'attachments';
    public const RESOURCE_BUSINESS_PARTNER = 'businesspartners';
    public const RESOURCE_DIMENSION = 'dimensions';
    public const RESOURCE_INVOICE = 'invoices';
    public const REOURCE_LEDGER_RECEIPT = 'ledgerreceipts';

    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private LoggerInterface $logger;
    private Environment $environment;
    private CacheItemPoolInterface $pool;


    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        LoggerInterface $logger,
        Environment $environment,
        CacheItemPoolInterface $pool
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->logger = $logger;
        $this->environment = $environment;
        $this->pool = $pool;
    }

    public function post(string $resourceName, AbstractResourceInterface $resource)
    {
        $request = $this->createRequest(self::HTTP_POST, $resourceName, $resource);
        return $this->request($request);
    }

    public function put(string $resourceName, AbstractResourceInterface $resource)
    {
        $request = $this->createRequest(self::HTTP_PUT, $resourceName, $resource);
        return $this->request($request);
    }

    public function get(string $resourceName)
    {
        $request = $this->createRequest(self::HTTP_GET, $resourceName);
        return $this->request($request);
    }

    public function request(RequestInterface $request)
    {
        $response = $this->httpClient->sendRequest($request);
        $result = $response->getBody()->getContents();
        $this->logger->info('Procountor request', [
            'url'     => $request->getUri(),
            'method'  => $request->getMethod(),
            'headers' => json_encode($request->getHeaders()),
            'body'    => $request->getBody()->getContents(),
            'status'  => $response->getStatusCode(),
        ]);
        if (
            $request->getHeader('Content-Type') === 'application/json'
            || $request->getHeader('Accept') === 'application/json'
        ) {
            return json_decode($result);
        }
        return $result;
    }

    public function createRequest(string $method, string $resourceName, ?AbstractResourceInterface $resource = null): RequestInterface
    {
        // Nuke leading slashes, otherwise UriInterface would treat it as an absolute path removing /api-version/api
        $resourceName = ltrim($resourceName, '/');
        $url = $this->environment->getBaseUri()->withPath($resourceName);
        $request = $this->requestFactory->createRequest($method, $url);
        if ($resource) {
            $builder = new Builder();
            $builder->setResource($resource);
            $requestBody = $builder->getJson();
            $request = $request->withBody($this->streamFactory->createStream($requestBody));
        }
        return $request
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json')
            ->withHeader('Authorization', sprintf('Bearer %s', $this->getAccessToken()));
    }

    private function getAccessTokenByApiKey(): array
    {
        $request = $this->requestFactory
            ->createRequest(self::HTTP_POST, $this->environment->accessTokenUri())
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withHeader('Accept', 'application/json')
            // body must be a stream & our content type must be urlencoed
            ->withBody($this->streamFactory->createStream(http_build_query([
                'grant_type'    => 'client_credentials',
                'api_key'       => $this->environment->getApiKey(),
                'client_id'     => $this->environment->getClientId(),
                'client_secret' => $this->environment->getClientSecret(),
                'redirect_uri'  => $this->environment->getRedirectUri(),
            ])));
        $result = $this->request($request);
        return [$result->access_token, $result->expires_in];
    }

    private function getAccessToken(): string
    {
        $accessKeyItem = $this->pool->getItem('procountor_access_token');
        if ($accessKeyItem->isHit()) {
            $accessKey = $accessKeyItem->get();
        } else {
            [$accessKey, $expires] = $this->getAccessTokenByApiKey();
            $accessKeyItem->set($accessKey);
            // https://dev.procountor.com/m2m-authentication/#client%20credentials%20grant%20flow_1
            $accessKeyItem->expiresAfter($expires);
            $this->pool->save($accessKeyItem);
        }
        return $accessKey;
    }
}
