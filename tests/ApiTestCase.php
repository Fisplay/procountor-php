<?php

namespace Tests;

use Cache\Adapter\PHPArray\ArrayCachePool;
use Dotenv\Dotenv;
use GuzzleHttp\Client as GuzzleHttpClient;
use PhpExtended\HttpMessage\RequestFactory;
use PhpExtended\HttpMessage\StreamFactory;
use PhpExtended\HttpMessage\UriFactory;
use PHPUnit\Framework\TestCase;
use Procountor\Procountor\Client;
use Procountor\Procountor\Environment;
use Psr\Log\NullLogger;

class ApiTestCase extends TestCase
{
    public function createClient()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..', '.env.testing');
        $dotenv->load();

        $prcountorEnv = new Environment(
            $_ENV['PROCOUNTOR_CLIENT_ID'],
            $_ENV['PROCOUNTOR_CLIENT_SECRET'],
            $_ENV['PROCOUNTOR_API_KEY'] ?? null,
            $_ENV['PROCOUNTOR_BASE_URI'],
            $_ENV['PROCOUNTOR_REDIRECT_URI'],
            new UriFactory()
        );

        return new Client(
            new GuzzleHttpClient(),
            new RequestFactory(),
            new StreamFactory(),
            new NullLogger(),
            $prcountorEnv,
            new ArrayCachePool()
        );
    }
}
