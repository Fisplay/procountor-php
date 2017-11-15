<?php
namespace Procountor\Collection;

use Procountor\Interfaces\TravelInformationItemInterface;

class TravelInformationItemsCollection extends AbstractCollection {
    public function addItem(TravelInformationItemInterface $item): AbstractCollection
    {
        $this->items[] = $item;
        return $this;
    }
}
