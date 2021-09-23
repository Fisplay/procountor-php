<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use ArrayIterator;
use IteratorAggregate;
use Countable;

abstract class AbstractCollection implements IteratorAggregate, Countable
{
    private $items = [];

    //PHP 7.2 ONWARDS :)
    //abstract public function addItem(AbstractResourceInterface $item): AbstractCollection;

    public function addItemToCollection($item, $skipcheck = false)
    {
        if (!$skipcheck && !($item instanceof AbstractResourceInterface)) {
            throw new \Exception('Invalid item');
        }

        $this->items[] = $item;
        return $this;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    public function count()
    {
        return $this->getIterator()->count();
    }
}
