<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\ExtraInfoInterface;


/**
 * class ExtraInfo
 *
 * @see Procountor\Procountor\Interfaces\ExtraInfoInterface
 * @see https://dev.procountor.com/api-reference/#model-ExtraInfo
 *
 * @package Procountor\Procountor\Response
 */
class ExtraInfo extends AbstractResponse implements ExtraInfoInterface
{

    public function getAccountingByRow(): bool
    {
        return $this->data->accountingByRow;
    }

    public function getUnitPricesIncludeVat(): bool
    {
        return $this->data->unitPricesIncludeVat;
    }
}
