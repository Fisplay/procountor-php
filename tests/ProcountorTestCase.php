<?php

namespace Procountor\Tests;

use Cache\Adapter\PHPArray\ArrayCachePool;
use Dotenv\Dotenv;
use GuzzleHttp\Client as GuzzleHttpClient;
use PhpExtended\HttpMessage\RequestFactory;
use PhpExtended\HttpMessage\ResponseFactory;
use PhpExtended\HttpMessage\StreamFactory;
use PhpExtended\HttpMessage\UriFactory;
use PHPUnit\Framework\TestCase;
use Procountor\Procountor\Client;
use Procountor\Procountor\Environment;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ProcountorTestCase extends TestCase
{

    private ResponseFactory $responseFactory;
    private StreamFactory $streamFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->responseFactory = new ResponseFactory();
        $this->streamFactory = new StreamFactory();
        $this->cachePool = new ArrayCachePool();
    }

    public function createClient(
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        ?LoggerInterface $logger = null,
        ?Environment $environment = null,
        ?CacheItemPoolInterface $cachePool = null
    ) {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..', '.env.testing');
        $dotenv->load();

        if (is_null($environment)) {
            $environment = new Environment(
                $_ENV['PROCOUNTOR_CLIENT_ID'],
                $_ENV['PROCOUNTOR_CLIENT_SECRET'],
                $_ENV['PROCOUNTOR_API_KEY'] ?? null,
                $_ENV['PROCOUNTOR_BASE_URI'],
                $_ENV['PROCOUNTOR_REDIRECT_URI'],
                new UriFactory()
            );
        }

        return new Client(
            $httpClient ?? new GuzzleHttpClient(),
            $requestFactory ?? new RequestFactory(),
            $streamFactory ?? new StreamFactory(),
            $logger ?? new NullLogger(),
            $environment,
            $cachePool ?? new ArrayCachePool()
        );
    }

    public function createResponse(int $status, ?string $body = null, array $headers = [],  string $reasonPhrase = '')
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
