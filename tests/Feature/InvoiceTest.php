<?php

use Procountor\Procountor\Collection\InvoiceCollection;
use Procountor\Procountor\Interfaces\Read\Invoice as ReadInvoice;
use Procountor\Procountor\Resources\Invoices;
use Procountor\Tests\ApiTestCase;
use Procountor\Tests\TestDoubles\Invoice;


it('can create invoice', function () {
    /** @var ApiTestCase $this */

    $invoicesApi = new Invoices($this->createClient());

    /** @var ReadInvoice $createdInvoice */
    $createdInvoice = $invoicesApi->post(new Invoice());
    $this->assertInstanceOf(ReadInvoice::class, $createdInvoice);
    $this->assertIsNumeric($createdInvoice->getId());

    /** @var ReadInvoice $fetchedInvoice */
    $fetchedInvoice = $invoicesApi->get($createdInvoice->getId());
    $this->assertEquals($createdInvoice, $fetchedInvoice);

})
    ->skip(fn () => !isset($_ENV['REAL_API_REQUESTS']))
    ->group('invoice');


it('returns InvoiceCollection when querying', function () {
    /** @var ApiTestCase $this */

    $invoicesApi = new Invoices($this->createClient());

    /** @var InvoiceCollection $invoiceCollection */
    $invoiceCollection = $invoicesApi->get();
    $this->assertInstanceOf(InvoiceCollection::class, $invoiceCollection);
    // $this->assertIsNumeric($createdInvoice->getId());

})
    ->skip(fn () => !isset($_ENV['REAL_API_REQUESTS']))
    ->group('invoice');
