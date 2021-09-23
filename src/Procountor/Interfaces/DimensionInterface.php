<?php

namespace Procountor\Procountor\Interfaces;

use Procountor\Procountor\Collection\DimensionItemCollection;

interface DimensionInterface extends AbstractResourceInterface
{
    //Dimension ID. ,
    public function getId(): int;

    //Dimension name. ,
    public function getName(): string;

    //Dimension items.
    public function getItems(): ?DimensionItemCollection;
}
