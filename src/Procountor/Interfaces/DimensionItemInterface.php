<?php
namespace Procountor\Interfaces;


interface DimensionItemInterface extends AbstractResourceInterface {
    //Dimension item ID. ,
    public function getId(): int;

    //Dimension item code name. ,
    public function getCodeName(): string;

    //Dimension item status. If the dimension item is marked as active, this property is not present. If the dimension item is inactive, the value of this is property is "P". ,
    public function getStatus(): ?string;

    //Dimension item description.
    public function getDescription(): ?string;

}

