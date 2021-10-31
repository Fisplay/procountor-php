<?php

namespace Procountor\Procountor;

use InvalidArgumentException;
use Procountor\Helpers\Http;
use Procountor\Helpers\LoggerDecorator;
use Procountor\Procountor\Exceptions\ValidationException;
use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use Procountor\Procountor\Json\Builder;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use ReflectionException;
use RuntimeException;


/**
 * class Client
 *
 * Wrapper for HTTP client. Contains helper methods & handles resource serialization & deserialization.
 *
 * @package Procountor\Procountor
 */
class Client
{
    public const RESOURCE_ATTACHMENT = 'attachments';
    public const RESOURCE_BUSINESS_PARTNER = 'businesspartners';
    public const RESOURCE_DIMENSION = 'dimensions';
    public const RESOURCE_INVOICE = 'invoices';
    public const REOURCE_LEDGER_RECEIPT = 'ledgerreceipts';

    protected ClientInterface $httpClient;
    protected RequestFactoryInterface $requestFactory;
    protected StreamFactoryInterface $streamFactory;
    protected LoggerDecorator $logger;
    protected Environment $environment;
    protected CacheItemPoolInterface $pool;


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
        $this->logger = new LoggerDecorator($logger);
        $this->environment = $environment;
        $this->pool = $pool;
    }

    public function post(string $resourceName, AbstractResourceInterface $resource)
    {
        $request = $this->createRequest(Http::POST, $resourceName, $resource);
        return $this->request($request);
    }

    public function put(string $resourceName, AbstractResourceInterface $resource)
    {
        $request = $this->createRequest(Http::PUT, $resourceName, $resource);
        return $this->request($request);
    }

    public function get(string $resourceName, ?array $searchParams = null)
    {
        $request = $this->createRequest(Http::GET, $resourceName);
        if (!empty($searchParams)) {
            $newUrl = $request->getUri()->withQuery(http_build_query($searchParams));
            $request = $request->withUri($newUrl);
        }
        return $this->request($request);
    }

    /**
     * Execute the request. If either request's Accept or responses Content-Type is set
     * to JSON, returns decoded JSON body as objec. Otherwise returns request's string
     * body.
     *
     * @param RequestInterface $request
     * @return string|array|object
     * @throws ClientExceptionInterface
     * @throws ValidationException
     * @throws RuntimeException
     */
    public function request(RequestInterface $request)
    {
        $response = $this->httpClient->sendRequest($request);
        $this->logger->logRequest('Procountor request', $request, $response);

        switch ($response->getStatusCode()) {
            case Http::BAD_REQUEST:
                throw new ValidationException($response);
            default:
                return Http::responseBody($response);
        }
    }

    /**
     * Create new request to pass onto API client.
     *
     * @param string $method
     * @param string $resourceName
     * @param null|AbstractResourceInterface $resource Required when creating new resources
     * @return RequestInterface
     * @throws InvalidArgumentException
     * @throws ReflectionException
     * @throws RuntimeException
     * @throws ClientExceptionInterface
     * @throws ValidationException
     */
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

    protected function getAccessTokenByApiKey(): array
    {
        $request = $this->requestFactory
            ->createRequest(Http::POST, $this->environment->accessTokenUri())
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
        if ($this->environment->debug()) {
            $this->logger->debug(
                'Access token requested',
                [
                    'request'  => $request,
                    'response' => $result,
                ]
            );
        }
        return [$result->access_token, $result->expires_in];
    }

    protected function getAccessToken(): string
    {
        $accessKeyItem = $this->pool->getItem($this->environment->getCacheKey());
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
