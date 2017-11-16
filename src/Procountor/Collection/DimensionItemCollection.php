<?php
namespace Procountor\Collection;

use Procountor\Interfaces\DimensionItemInterface;

class DimensionItemCollection extends AbstractCollection {
    public function addItem(DimensionItemInterface $item): AbstractCollection
    {
        $this->addItemToCollection($item, true);
        return $this;
    }

}

