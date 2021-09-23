<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\DimensionItemInterface;

class DimensionItem extends AbstractResponse implements DimensionItemInterface
{
    //Dimension item ID. ,
    public function getId(): int
    {
        return $this->data->id;
    }

    //Dimension item code name. ,
    public function getCodeName(): string
    {
        return $this->data->codeName;
    }

    //Dimension item status. If the dimension item is marked as active, this property is not present. If the dimension item is inactive, the value of this is property is "P". ,
    public function getStatus(): ?string
    {
        return $this->data->status ?? null;
    }

    //Dimension item description.
    public function getDescription(): ?string
    {
        return $this->data->description ?? null;
    }
}
