<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use ArrayIterator;
use IteratorAggregate;
use Countable;
use TypeError;

abstract class AbstractCollection implements IteratorAggregate, Countable
{
    private array $items = [];

    abstract public function addItem(AbstractResourceInterface $item): AbstractCollection;

    public function addItemToCollection($item, $skipcheck = false)
    {
        if (!$skipcheck && !($item instanceof AbstractResourceInterface)) {
            throw new TypeError('Invalid item');
        }

        $this->items[] = $item;
        return $this;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return $this->getIterator()->count();
    }
}
