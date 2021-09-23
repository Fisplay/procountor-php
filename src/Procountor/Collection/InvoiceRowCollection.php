<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\InvoiceRowInterface;

class InvoiceRowCollection extends AbstractCollection
{
    public function addItem(InvoiceRowInterface $item): AbstractCollection
    {
        $this->addItemToCollection($item);
        return $this;
    }
}
