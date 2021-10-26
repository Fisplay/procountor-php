<?php

namespace Procountor\Tests;

use Procountor\Procountor\Collection\AbstractCollection;
use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use TypeError;

class TestCollection extends AbstractCollection
{

    public function __construct(AbstractResourceInterface ...$items )
    {
        $this->items = $items;
    }

    public function addItem($item): TestCollection
    {
        if (!($item instanceof AbstractResourceInterface)) {
            throw new TypeError('TestCollection accepts any AbstractResourceInterface');
        }
        array_push($this->items, $item);
        return $this;
    }

}
