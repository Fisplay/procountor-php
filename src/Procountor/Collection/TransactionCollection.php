<?php
namespace Procountor\Collection;

use Procountor\Interfaces\TransactionCommon;

class TransactionCollection extends AbstractCollection {
    public function addItem(TransactionCommon $item): AbstractCollection
    {
        $this->addItemToCollection($item);
        return $this;
    }

}
