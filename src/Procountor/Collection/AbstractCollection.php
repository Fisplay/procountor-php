<?php
namespace Procountor\Collection;

use Procountor\Interfaces\AbstractResourceInterface;

use ArrayIterator;
use IteratorAggregate;
use Countable;

abstract class AbstractCollection implements IteratorAggregate, Countable
{
    private $items = [];

    //PHP 7.2 ONWARDS :)
    //abstract public function addItem(AbstractResourceInterface $item): AbstractCollection;

    public function addItemToCollection($item)
    {
        if (!($item instanceof AbstractResourceInterface)) {
            throw new \Exception('Invalid item');
        }

        $this->items[] = $item;
        return $this;
    }

    public function getIterator() {
        return new ArrayIterator($this->items);
    }

    public function count() {
        return $this->getIterator()->count();
    }

}
