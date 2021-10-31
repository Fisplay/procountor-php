<?php

namespace Procountor\Tests;

use Dotenv\Dotenv;
use Faker\Factory as FakerFactory;
use Faker\Generator;
use GuzzleHttp\Client as GuzzleHttpClient;
use PhpExtended\HttpMessage\RequestFactory;
use PhpExtended\HttpMessage\ResponseFactory;
use PhpExtended\HttpMessage\StreamFactory;
use PhpExtended\HttpMessage\UriFactory;
use PHPUnit\Framework\TestCase;
use Procountor\Procountor\Client;
use Procountor\Procountor\Environment;
use Procountor\Tests\TestDoubles\NullCachePool;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ApiTestCase extends TestCase
{

    public Generator $faker;
    protected Environment $environment;
    protected ResponseFactory $responseFactory;
    protected StreamFactory $streamFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $dotenv = Dotenv::createImmutable(__DIR__ . '/..', '.env.testing');
        $dotenv->load();

        $this->responseFactory = new ResponseFactory();
        $this->streamFactory = new StreamFactory();
        $this->cachePool = new NullCachePool();
        $this->faker = FakerFactory::create();
        $this->environment = new Environment(
            $_ENV['PROCOUNTOR_CLIENT_ID'],
            $_ENV['PROCOUNTOR_CLIENT_SECRET'],
            $_ENV['PROCOUNTOR_API_KEY'] ?? null,
            $_ENV['PROCOUNTOR_BASE_URI'],
            $_ENV['PROCOUNTOR_REDIRECT_URI'],
            new UriFactory()
        );
    }

    public function createClient(
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        ?LoggerInterface $logger = null,
        ?Environment $environment = null,
        ?CacheItemPoolInterface $cachePool = null
    ) {
        return new Client(
            $httpClient ?? new GuzzleHttpClient(['verify' => $_ENV['HTTPS_PROXY_CA_CERT'] ?? true]),
            $requestFactory ?? new RequestFactory(),
            $streamFactory ?? new StreamFactory(),
            $logger ?? new NullLogger(),
            $environment ?? $this->environment,
            $cachePool ?? new NullCachePool()
        );
    }

    public function jsonResponse(int $status, $body): ResponseInterface
    {
        return $this->createResponse($status, json_encode($body), ['Content-Type' => 'application/json']);
    }

    public function createResponse(int $status, ?string $body = null, array $headers = [],  string $reasonPhrase = ''): ResponseInterface
    {
        $reponse = $this->responseFactory->createResponse($status, $reasonPhrase);
        if (!empty($headers)) {
            foreach ($headers as $name => $value) {
                $reponse = $reponse->withHeader($name, $value);
            }
        }
        if (!is_null($body)) {
            $reponse = $reponse->withBody($this->streamFactory->createStream($body));
        }
        return $reponse;
    }

}
