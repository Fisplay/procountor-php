<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\DimensionInterface;
use Procountor\Procountor\Collection\DimensionItemCollection;
use TypeError;

class Dimension extends AbstractResponse implements DimensionInterface
{

    /**
     * Get the dimension ID
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->data->id;
    }

    /**
     * Get the dimension name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->data->name;
    }

    /**
     * @return null|DimensionItemCollection<DimensionItem>
     * @throws TypeError
     */
    public function getItems(): ?DimensionItemCollection
    {
        if (empty($this->data->items)) {
            return null;
        }

        return new DimensionItemCollection(...array_map(
            fn ($item) => new DimensionItem($item),
            $this->data->items
        ));
    }
}
