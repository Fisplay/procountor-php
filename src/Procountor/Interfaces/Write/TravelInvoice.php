<?php

namespace Procountor\Procountor\Interfaces\Write;

use Procountor\Procountor\Collection\TravelInformationItemsCollection;
use Procountor\Procountor\Interfaces\InvoiceCommon;


/**
 * interface TravelInvoice
 *
 * Write-spesific interface for travel invoices.
 *
 * @see Procountor\Procountor\Interfaces\InvoiceCommon;
 *
 * @package Procountor\Procountor\Interfaces\Write
 */
interface TravelInvoice extends InvoiceCommon
{

    /**
     * Travel information items.
     * Travel invoice may have one or more travel information items containing:
     * - departure date
     * - return date
     * - destinations
     * - travel purpose
     *
     * @return null|TravelInformationItemsCollection
     */
    public function getTravelInformationItems(): ?TravelInformationItemsCollection;
}
