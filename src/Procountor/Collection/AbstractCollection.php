<?php
namespace Procountor\Collection;

use Procountor\Interfaces\AbstractResourceInterface;

use ArrayIterator;
use IteratorAggregate;
use Countable;
use Traversable;

abstract class AbstractCollection implements IteratorAggregate, Countable
{
    private $items = [];

    //PHP 7.2 ONWARDS :)
    //abstract public function addItem(AbstractResourceInterface $item): AbstractCollection;

    public function addItemToCollection($item, $skipCheck = false)
    {
        if (!$skipCheck && !($item instanceof AbstractResourceInterface)) {
            throw new \Exception('Invalid item');
        }

        $this->items[] = $item;
        return $this;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->getIterator());
    }
}
