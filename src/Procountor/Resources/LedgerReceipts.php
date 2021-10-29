<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Interfaces\Read\LedgerReceipt as LedgerReceiptIn;
use Procountor\Procountor\Response\LedgerReceipt as LedgerReceiptOut;


class LedgerReceipts extends AbstractResourceRequest
{
    protected static $apiPath = 'ledgerreceipts';
    protected static $interfaceIn = LedgerReceiptIn::class;
    protected static $interfaceOut = LedgerReceiptOut::class;
}
