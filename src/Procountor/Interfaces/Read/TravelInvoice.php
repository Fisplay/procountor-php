<?php

namespace Procountor\Procountor\Interfaces\Read;

use Procountor\Procountor\Collection\TravelInformationItemsCollection;

/**
 * interface TravelInvoice
 *
 * Read-spesific interface for travel invoices.
 *
 * @see Procountor\Procountor\Interfaces\InvoiceCommon;
 *
 * @package Procountor\Procountor\Interfaces\Read
 */
interface TravelInvoice extends Invoice
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
