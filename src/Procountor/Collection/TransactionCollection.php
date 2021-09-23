<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\TransactionCommon;

class TransactionCollection extends AbstractCollection
{
    public function addItem(TransactionCommon $item): AbstractCollection
    {
        $this->addItemToCollection($item);
        return $this;
    }
}
