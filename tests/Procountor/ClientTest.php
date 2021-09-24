<?php

namespace Procountor\Procountor;

use Tests\ApiTestCase;

class ClientTest extends ApiTestCase
{
    public function testRequestCallsLogger()
    {
        $client = $this->createClient();

        $client->request('localhost', 'POST', '{"Content-Type": "application/json"}', '{a: b}');
        $requestLog = $logger->log[0];
        unset($requestLog[5]);
        $this->assertEquals([
            0 => 'localhost',
            1 => 'POST',
            2 => '{"Content-Type": "application/json"}',
            3 => '{a: b}',
            4 => '404',
            // 5 => '{"Server":["nginx"],"Date":["Thu, 05 Apr 2018 06:28:21 GMT"],"Content-Type":["text\/html;charset=utf-8"],"Content-Length":["1105"],"Connection":["keep-alive"],"Content-Language":["en"]}',
            6 => '{}'
        ], $requestLog);

        $responseHeaders = json_decode($logger->log[0][5], true);
        $this->assertEquals('nginx', $responseHeaders['Server'][0]);
    }

    public function testStatuscodeOtherThan200CallsError()
    {
        $client = $this->createClient();
        $this->markTestIncomplete();
    }

    /**
     * Test that authentication works
     */
    public function testAuthenticateByApiKey()
    {
        $refClass = new \ReflectionClass(Client::class);
        $refProp = $refClass->getProperty('accessToken');
        $refProp->setAccessible(true);

        $client = $this->createClient();

        $this->assertNotNull($refProp->getValue($client));
    }
}
