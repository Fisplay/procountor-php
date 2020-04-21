<?php

namespace Procountor;

use PHPUnit\Framework\TestCase;
use Procountor\Interfaces\LoggerInterface;

class ClientTest extends TestCase
{
    public function testRequestCallsLogger()
    {
        $logger = new class () implements LoggerInterface {
            public $log = [];
            public function log(
                string $requestUrl,
                string $requestType,
                string $requestHeaders,
                string $requestBody,
                string $responseStatusCode,
                string $responseHeaders,
                string $responseBody
            ) {
                $this->log[] = [
                    $requestUrl,
                    $requestType,
                    $requestHeaders,
                    $requestBody,
                    $responseStatusCode,
                    $responseHeaders,
                    $responseBody
                ];
            }
        };
        $client = new Client($logger);

        $client->request('localhost', 'POST', '{"Content-Type": "application/json"}', '{a: b}');
        $this->assertArraySubset([
            0 => 'localhost',
            1 => 'POST',
            2 => '{"Content-Type": "application/json"}',
            3 => '{a: b}',
            4 => '404',
            //'{"Server":["nginx"],"Date":["Thu, 05 Apr 2018 06:28:21 GMT"],"Content-Type":["text\/html;charset=utf-8"],"Content-Length":["1105"],"Connection":["keep-alive"],"Content-Language":["en"]}',
            6 => '{}'
        ], $logger->log[0]);

        $responseHeaders = json_decode($logger->log[0][5], true);
        $this->assertEquals('nginx', $responseHeaders['Server'][0]);
    }

    public function testStatuscodeOtherThan200CallsError()
    {
        $logger = new class () implements LoggerInterface {
            public $log = [];
            public function log(
                string $requestUrl,
                string $requestType,
                string $requestHeaders,
                string $requestBody,
                string $responseStatusCode,
                string $responseHeaders,
                string $responseBody
            ) {
                $this->log[] = [
                    $requestUrl,
                    $requestType,
                    $requestHeaders,
                    $requestBody,
                    $responseStatusCode,
                    $responseHeaders,
                    $responseBody
                ];
            }
        };
        $client = new Client($logger);
        $this->markTestIncomplete();
    }
}
