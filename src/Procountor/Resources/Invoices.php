<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Collection\InvoiceCollection;
use Procountor\Procountor\Interfaces\Read\Invoice as InvoiceIn;
use Procountor\Procountor\Response\Invoice as InvoiceOut;


class Invoices extends AbstractResourceRequest
{

    protected string $apiPath = 'invoices';
    protected string $interfaceIn = InvoiceIn::class;
    protected string $interfaceOut = InvoiceOut::class;
    protected string $collectionType = InvoiceCollection::class;

}
