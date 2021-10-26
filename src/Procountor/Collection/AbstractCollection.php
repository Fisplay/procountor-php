<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use ArrayIterator;
use IteratorAggregate;
use Countable;

abstract class AbstractCollection implements IteratorAggregate, Countable
{

    /** @var array<AbstractResourceInterface> $items */
    protected array $items = [];

    /**
     * Add item into collection
     * @template AbstractResource
     * @param AbstractResource $item
     * @return self<AbstractResource>
     */
    abstract public function addItem($item): AbstractCollection;

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Get the count of items in the collection
     *
     * @return int
     */
    public function count(): int
    {
        return $this->getIterator()->count();
    }
}
