<?php
namespace Procountor\Collection;

use Procountor\Interfaces\InvoiceRowInterface;

class InvoiceRowCollection extends AbstractCollection {
    public function addItem(InvoiceRowInterface $item): AbstractCollection
    {
        $this->addItemToCollection($item);
        return $this;
    }

}
