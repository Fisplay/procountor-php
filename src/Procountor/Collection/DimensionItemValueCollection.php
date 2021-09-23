<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\DimensionItemValueInterface;

class DimensionItemValueCollection extends AbstractCollection
{
    public function addItem(DimensionItemValueInterface $item): AbstractCollection
    {
        $this->addItemToCollection($item, true);
        return $this;
    }
}
