<?php
namespace Procountor\Resources;

use Procountor\Client;
use Procountor\Interfaces\Read\LedgerReceipt as LedgerReceiptIn;
use Procountor\Response\LedgerReceipt as LedgerReceiptOut;

class LedgerReceipts extends AbstractResourceRequest {
    protected $apiPath = 'ledgerreceipts';
    protected $interfaceIn = LedgerReceiptIn::class;
    protected $interfaceOut = LedgerReceiptOut::class;



}

