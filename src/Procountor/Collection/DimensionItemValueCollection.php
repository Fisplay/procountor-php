<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\DimensionItemValueInterface;
use TypeError;

class DimensionItemValueCollection extends AbstractCollection
{

    public function __construct(DimensionItemValueInterface ...$items)
    {
        $this->items = $items;
    }

    public function addItem($item): AbstractCollection
    {
        if (!($item instanceof DimensionItemValueInterface)) {
            throw new TypeError('DimensionItemValueCollection expects instances of DimensionItems');
        }

        $this->items[] = $item;
        return $this;
    }

}
