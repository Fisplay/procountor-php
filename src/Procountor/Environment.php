<?php

namespace Procountor\Procountor;

use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;

class Environment
{

    private string $clientId;
    private string $clientSecret;
    private ?string $apiKey = null;
    private string $apiVersion;
    private UriInterface $baseUri;
    private UriInterface $redirectUri;

    public function __construct(
        string $clientId,
        string $clientSecret,
        ?string $apiKey,
        string $baseUri,
        string $redirectUri,
        UriFactoryInterface $uriFactory,
        string $apiVersion = 'latest'
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->apiKey = $apiKey;
        $this->baseUri = $uriFactory->createUri($baseUri);
        $this->redirectUri = $uriFactory->createUri($redirectUri);
        $this->apiVersion = $apiVersion;
    }

    public function accessTokenUri(): UriInterface
    {
        return $this->baseUri->withPath('/oauth/token');
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * If API key is null, you must authorize the application first.
     * Use artisan console command or run manually.
     * ```
     * php artisan procountor:authorize
     * ```
     * @see https://dev.procountor.com/m2m-authentication/
     *
     * @return null|string
     */
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }

    public function getBaseUri(): UriInterface
    {
        return $this->baseUri->withPath("/{$this->apiVersion}/api");
    }

    public function getRedirectUri(): UriInterface
    {
        return $this->redirectUri;
    }
}
