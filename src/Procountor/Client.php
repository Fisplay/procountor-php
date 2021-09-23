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

    public const ENV_PRODUCTION = 'production';
    public const ENV_DEVELOPMENT = 'development';

    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;
    private StreamFactoryInterface $streamFactory;
    private LoggerInterface $logger;
    private string $apiVersion;
    private string $mode;
    private string $accessToken;
    private array $loginParameters;


    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        LoggerInterface $logger,
        string $apiVersion = 'latest',
        string $mode = self::ENV_DEVELOPMENT
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->logger = $logger;
        $this->apiVersion = $apiVersion;
    }

    public function authenticateByApiKey(
        string $clientId,
        string $clientSecret,
        string $redirectUri,
        string $apiKey,
        int $company
    ): self {
        $this->loginParameters = [
            'clientId'     => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri'  => $redirectUri,
            'apiKey'       => $apiKey,
            'company'      => $company,
        ];

        $this->accessToken = $this->getAccessTokenByApiKey($apiKey);
        return $this;
    }

    public function post(string $resourceName, AbstractResourceInterface $resource)
    {
        return $this->createRequest('POST', $resourceName, $resource);
    }

    public function put(string $resourceName, AbstractResourceInterface $resource)
    {
        return $this->createRequest('PUT', $resourceName, $resource);
    }

    public function request(RequestInterface $request, string $headers, string $data)
    {
        $request->withHeader()
        $params = [
            'headers' => json_decode($headers, true),
        ];

        if ($params['headers']['Content-Type'] === 'application/json') {
            $params['json'] = json_decode($data, true);
        } else {
            $params['form_params'] = json_decode($data, true);
        }

        $request = $this->httpClient->sendRequest($type, $url, $params);

        $this->logger->log(
            $url,
            $type,
            $headers,
            $data,
            $request->getStatusCode(),
            json_encode($request->getHeaders()),
            json_encode($request->getBody())
        );


        return $request;
    }

    public function createRequest(string $method, string $resourceName, ?AbstractResourceInterface $resource = null): RequestInterface
    {
        $request = $this->requestFactory->createRequest($method, $this->getResourceUrl($resourceName));
        if ($resource) {
            $builder = new Builder();
            $builder->setResource($resource);
            $requestBody = $builder->getJson();
            $request = $request->withBody($this->streamFactory->createStream($requestBody));
        }
        return $request
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Authorization', sprintf('Bearer %s', $this->accessToken));
    }

    public function get(string $resourceName)
    {
        //$response = $this->httpClient->request('GET', $this->getResourceUrl($resourceName), $this->getRequestAuthHeaders())->getBody();
        return $this->createRequest('GET', $resourceName);
    }

    private function getResourceUrl(string $resourceName): string
    {
        return sprintf('%s/%s', $this->getBaseUri(), $resourceName);
    }

    private function getAccessTokenByApiKey(string $code): string
    {

        $post = [
            'api_key' => $code,
            'client_id' => $this->loginParameters['clientId'],
            'client_secret' => $this->loginParameters['clientSecret'],
            'redirect_uri' => $this->loginParameters['redirectUri'],
        ];
        $url = sprintf(
            '%s?grant_type=client_credentials&',
            $this->getUrlAccessToken()
        ) . http_build_query($post);

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $request = $this->request($url, 'POST', json_encode($headers), json_encode($post));
        $result = json_decode($request->getBody());

        if (!empty($result->error)) {
            $this->error($result);
        }
        return $result->access_token;
    }

    private function error($result)
    {
        throw new ClientException($result->errors[0]->message);
    }

    private function getUrlAccessToken(): string
    {
        return $this->getBaseUri() . '/oauth/token';
    }

    private function getBaseUri(): string
    {
        switch ($this->mode) {
            case self::ENV_PRODUCTION:
                return 'https://api.procountor.com/' . $this->apiVersion . '/api';
            case self::ENV_DEVELOPMENT:
            default:
                return 'https://api-test.procountor.com/' . $this->apiVersion . '/api';
        }
    }
}
