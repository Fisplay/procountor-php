<?php

namespace Procountor\Procountor;

use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use Procountor\Procountor\Json\Builder;
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

    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private LoggerInterface $logger;
    private Environment $environment;
    private string $accessToken;


    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        LoggerInterface $logger,
        Environment $environment
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->logger = $logger;
        $this->environment = $environment;
    }

    public function authenticateByApiKey(): self
    {
        $request = $this->requestFactory
            ->createRequest(self::HTTP_POST, $this->environment->accessTokenUri())
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withHeader('Accept', 'application/json')
            // body must be a stream & our content type must be urlencoed
            ->withBody($this->streamFactory->createStream(http_build_query([
                'grant_type'    => 'client_credentials',
                'api_key'       => $this->environment->apiKey,
                'client_id'     => $this->environment->clientId,
                'client_secret' => $this->environment->clientSecret,
                'redirect_uri'  => $this->environment->redirectUri,
            ])));
        $result = $this->request($request);
        $this->accessToken = $result->access_token;
        return $this;
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
            ->withHeader('Authorization', sprintf('Bearer %s', $this->accessToken));
    }
}
