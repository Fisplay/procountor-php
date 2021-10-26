<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\DimensionItemInterface;
use TypeError;

class DimensionItemCollection extends AbstractCollection
{

    public function __construct(DimensionItemInterface ...$items)
    {
        $this->items = $items;
    }

    public function addItem($item): AbstractCollection
    {
        if (!($item instanceof DimensionItemInterface)) {
            throw new TypeError('DimensionItemCollection expects instaces of Dimensions');
        }

        $this->items[] = $item;
        return $this;
    }

}
