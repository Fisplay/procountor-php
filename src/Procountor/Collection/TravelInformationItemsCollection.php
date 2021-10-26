<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\TravelInformationItemInterface;
use TypeError;

class TravelInformationItemsCollection extends AbstractCollection
{

    public function __construct(TravelInformationItemInterface ...$items)
    {
        $this->items = $items;
    }

    public function addItem($item): AbstractCollection
    {
        if (!($item instanceof TravelInformationItemInterface)) {
            throw new TypeError('TravelInformationItemsCollection expects instances of TravelInvoices');
        }

        $this->items[] = $item;
        return $this;
    }

}
