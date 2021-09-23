<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\DimensionItemInterface;

class DimensionItemCollection extends AbstractCollection
{
    public function addItem(DimensionItemInterface $item): AbstractCollection
    {
        $this->addItemToCollection($item, true);
        return $this;
    }
}
