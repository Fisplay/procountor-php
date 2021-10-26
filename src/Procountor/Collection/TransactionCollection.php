<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\TransactionCommon;
use TypeError;

class TransactionCollection extends AbstractCollection
{

    public function __construct(TransactionCommon ...$items)
    {
        $this->items = $items;
    }

    public function addItem($item): AbstractCollection
    {
        if (!($item instanceof TransactionCommon)) {
            throw new TypeError('TransactionCollection expects instances of Trasactions');
        }

        $this->items[] = $item;
        return $this;
    }

}
