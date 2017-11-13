<?php
namespace Procountor\Collection;

use Procountor\Interfaces\InvoiceRowInterface;

class TravelInformationCollection extends AbstractCollection {
    public function addItem(TravelInformationCollection $item): AbstractCollection
    {
        $this->items[] = $item;
        return $this;
    }
}
