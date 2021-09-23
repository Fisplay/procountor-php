<?php

namespace Procountor\Procountor\Response;

class DimensionList extends AbstractResponse
{

    public function getItems(): array
    {
        $ret = [];
        foreach ($this->data->items as $dimensionData) {
            $ret[] = new Dimension($dimensionData);
        }

        return $ret;
    }
}
