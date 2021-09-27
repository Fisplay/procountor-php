<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Interfaces\Read\Invoice as InvoiceIn;
use Procountor\Procountor\Response\Invoice as InvoiceOut;


class Invoices extends AbstractResourceRequest
{
    protected $apiPath = 'invoices';
    protected $interfaceIn = InvoiceIn::class;
    protected $interfaceOut = InvoiceOut::class;
}
