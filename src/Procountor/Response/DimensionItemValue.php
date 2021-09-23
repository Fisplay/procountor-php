<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\DimensionItemValueInterface;
use stdClass;

class DimensionItemValue extends AbstractResponse implements DimensionItemValueInterface
{

    //Dimension ID. Must exist in the current environment. For a list of available dimensions, see the GET /dimensions endpoint. ,
    public function getDimensionId(): ?int
    {
        return $this->data->dimensionId;
    }

    //Dimension item ID. Must exist in the current environment. For a list of available dimensions, see the GET /dimensions endpoint. ,
    public function getItemId(): int
    {
        return $this->data->itemId;
    }

    //Dimension item value with maximum two decimal places. Use absolute values instead of percentages. The sum of dimension item values on a dimension must equal the accounting value of the parent transaction.
    public function getValue(): float
    {
        return $this->data->value;
    }
}
