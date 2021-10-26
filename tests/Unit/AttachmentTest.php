<?php

use Procountor\Procountor\Response\Attachment;
use Procountor\Tests\UnitTestCase;

test('valid attachment json should parse', function () {

    /** @var UnitTestCase $this */

    $json = $this->getResponseJson('attachment');

    $exceptedInvoice = json_decode($json);
    $actualInvoice = new Attachment($exceptedInvoice);

    $this->assertProcountorResponseObject($exceptedInvoice, $actualInvoice);

})->group('response');
