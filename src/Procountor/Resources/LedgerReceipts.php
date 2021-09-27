<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Interfaces\Read\LedgerReceipt as LedgerReceiptIn;
use Procountor\Procountor\Response\LedgerReceipt as LedgerReceiptOut;


class LedgerReceipts extends AbstractResourceRequest
{
    protected $apiPath = 'ledgerreceipts';
    protected $interfaceIn = LedgerReceiptIn::class;
    protected $interfaceOut = LedgerReceiptOut::class;
}
