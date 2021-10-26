<?php

namespace Procountor\Procountor\Collection;

use TypeError;

class AllocationCollection extends AbstractCollection
{

    public function __construct(int ...$items)
    {
        $this->items = $items;
    }

    public function addItem($item): self
    {
        if (!is_int($item)) {
            throw new TypeError('AllocationCollection expects integers');
        }
        $this->items[] = $item;
        return $this;
    }
}
