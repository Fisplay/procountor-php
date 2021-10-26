<?php

use Procountor\Procountor\Response\LedgerReceipt;
use Procountor\Tests\UnitTestCase;

test('valid LedgerReceipt json should parse', function () {

    /** @var UnitTestCase $this */

    $exceptedLedgerReceipt = json_decode($this->getResponseJson('ledgerReceipt'));
    $actualLedgerReceipt = new LedgerReceipt($exceptedLedgerReceipt);

    $this->assertProcountorResponseObject($exceptedLedgerReceipt, $actualLedgerReceipt);

})->group('response');
