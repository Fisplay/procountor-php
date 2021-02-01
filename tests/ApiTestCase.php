<?php

namespace Tests;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Procountor\Client;
use Procountor\Interfaces\LoggerInterface;

class ApiTestCase extends TestCase
{
    public function createClient(LoggerInterface $logger = null)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..', '.env.testing');
        $dotenv->load();

        if (!$logger) {
            /** @var LoggerInterface */
            $logger = $this
                ->getMockBuilder(LoggerInterface::class)
                ->getMock();
        }

        $client = new Client($logger);
        $client->setModeDev();

        return $client->authenticateByApiKey(
            $_ENV['PROCOUNTOR_CLIENT_ID'],
            $_ENV['PROCOUNTOR_CLIENT_SECRET'],
            $_ENV['PROCOUNTOR_REDIRECT_URI'],
            $_ENV['PROCOUNTOR_API_KEY'],
            $_ENV['PROCOUNTOR_COMPANY']
        );
    }
}
