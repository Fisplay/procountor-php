<?php

use Procountor\Procountor\Response\Invoice;
use Procountor\Tests\UnitTestCase;

test('valid invoice json should parse', function () {

    /** @var UnitTestCase $this */

    $expectedInvoice = json_decode($this->getResponseJson('invoice'));
    $actualInvoice = new Invoice($expectedInvoice);

    $this->assertProcountorResponseObject($expectedInvoice, $actualInvoice);

})->group('response');
