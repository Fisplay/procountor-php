<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\TravelInformationItemInterface;

class TravelInformationItemsCollection extends AbstractCollection
{
    public function addItem(TravelInformationItemInterface $item): AbstractCollection
    {
        $this->items[] = $item;
        return $this;
    }
}
