<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use Procountor\Procountor\Interfaces\InvoiceRowInterface;
use TypeError;

class InvoiceRowCollection extends AbstractCollection
{
    public function addItem(AbstractResourceInterface $item): AbstractCollection
    {
        if (!($item instanceof InvoiceRowInterface)) {
            throw new TypeError('Invalid type. InvoiceRowInterface expected.');
        }
        $this->addItemToCollection($item);
        return $this;
    }
}
