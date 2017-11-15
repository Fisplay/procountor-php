<?php
namespace Procountor\Collection;

class AllocationCollection extends AbstractCollection {
    public function addItem(int $item): AbstractCollection
    {
        $this->addItemToCollection($item, true);
        return $this;
    }

}
