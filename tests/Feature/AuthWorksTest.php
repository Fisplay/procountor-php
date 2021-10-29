<?php

test('example', function () {
    expect(true)->toBeTrue();
    //     $refClass = new \ReflectionClass(Client::class);
    //     $refProp = $refClass->getProperty('accessToken');
    //     $refProp->setAccessible(true);

    //     $client = $this->createClient();

    //     $this->assertNotNull($refProp->getValue($client));
})->skip('Test incomplete');
