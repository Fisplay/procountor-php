<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\InvoiceRowInterface;
use TypeError;

class InvoiceRowCollection extends AbstractCollection
{

    public function __construct(InvoiceRowInterface ...$items)
    {
        $this->items = $items;
    }

    public function addItem($item): AbstractCollection
    {
        if (!($item instanceof InvoiceRowInterface)) {
            throw new TypeError('InvoiceRowCollection expects instances of InvoiceRows');
        }

        $this->items[] = $item;
        return $this;
    }

}
