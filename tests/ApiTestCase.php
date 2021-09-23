<?php

namespace Tests;

use Dotenv\Dotenv;
use GuzzleHttp\Client as GuzzleHttpClient;
use PhpExtended\HttpMessage\RequestFactory;
use PhpExtended\HttpMessage\StreamFactory;
use PHPUnit\Framework\TestCase;
use Procountor\Procountor\Client;
use Psr\Log\NullLogger;

class ApiTestCase extends TestCase
{
    public function createClient()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..', '.env.testing');
        $dotenv->load();

        $client = new Client(
            new GuzzleHttpClient(),
            new RequestFactory(),
            new StreamFactory(),
            new NullLogger()
        );

        return $client->authenticateByApiKey(
            $_ENV['PROCOUNTOR_CLIENT_ID'],
            $_ENV['PROCOUNTOR_CLIENT_SECRET'],
            $_ENV['PROCOUNTOR_REDIRECT_URI'],
            $_ENV['PROCOUNTOR_API_KEY'],
            $_ENV['PROCOUNTOR_COMPANY']
        );
    }
}
