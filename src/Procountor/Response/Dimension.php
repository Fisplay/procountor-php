<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\DimensionInterface;
use Procountor\Procountor\Collection\DimensionItemCollection;

class Dimension extends AbstractResponse implements DimensionInterface
{

    //Dimension ID. ,
    public function getId(): int
    {
        return $this->data->id;
    }

    //Dimension name. ,
    public function getName(): string
    {
        return $this->data->name;
    }

    //Dimension items.
    public function getItems(): ?DimensionItemCollection
    {
        if (empty($this->data->items)) {
            return null;
        }

        $collection = new DimensionItemCollection();
        foreach ($this->data->items as $item) {
            $dimensionItem = new DimensionItem($item);
            $collection->addItem($dimensionItem);
        }

        return $collection;
    }
}
