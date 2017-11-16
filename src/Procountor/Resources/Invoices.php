<?php
namespace Procountor\Resources;

use Procountor\Client;
use Procountor\Interfaces\Read\Invoice as InvoiceIn;
use Procountor\Response\Invoice as InvoiceOut;

class Invoices extends AbstractResourceRequest {
    protected $apiPath = 'invoices';
    protected $interfaceIn = InvoiceIn::class;
    protected $interfaceOut = InvoiceOut::class;
}
