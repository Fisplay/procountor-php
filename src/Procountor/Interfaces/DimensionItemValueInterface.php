<?php
namespace Procountor\Interfaces;


interface DimensionItemValueInterface extends AbstractResourceInterface {

    //Dimension ID. Must exist in the current environment. For a list of available dimensions, see the GET /dimensions endpoint. ,
    public function getDimensionId(): int;

    //Dimension item ID. Must exist in the current environment. For a list of available dimensions, see the GET /dimensions endpoint. ,
    public function getItemId(): int;

    //Dimension item value with maximum two decimal places. Use absolute values instead of percentages. The sum of dimension item values on a dimension must equal the accounting value of the parent transaction.
    public function getValue(): float;

}

