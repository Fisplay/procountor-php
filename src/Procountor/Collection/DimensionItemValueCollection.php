<?php
namespace Procountor\Collection;

use Procountor\Interfaces\DimensionItemValueInterface;

class DimensionItemValueCollection extends AbstractCollection {
    public function addItem(DimensionItemValueInterface $item): AbstractCollection
    {
        $this->addItemToCollection($item, true);
        return $this;
    }

}
