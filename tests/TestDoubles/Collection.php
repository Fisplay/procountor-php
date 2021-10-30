<?php

namespace Procountor\Tests\TestDoubles;

use Procountor\Procountor\Collection\AbstractCollection;
use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use TypeError;


class Collection extends AbstractCollection
{

    public function __construct(AbstractResourceInterface ...$items )
    {
        $this->items = $items;
    }

    public function addItem($item): Collection
    {
        if (!($item instanceof AbstractResourceInterface)) {
            throw new TypeError('Collection accepts any AbstractResourceInterface');
        }
        array_push($this->items, $item);
        return $this;
    }

}
