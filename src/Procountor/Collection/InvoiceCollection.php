<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\Read\Invoice;
use TypeError;

class InvoiceCollection extends AbstractCollection
{

    public function __construct(Invoice ...$items)
    {
        $this->items = $items;
    }

    public function addItem($item): AbstractCollection
    {
        if (!($item instanceof Invoice)) {
            throw new TypeError('InvoiceCollection expects instances of Invoices');
        }

        $this->items[] = $item;
        return $this;
    }

}
