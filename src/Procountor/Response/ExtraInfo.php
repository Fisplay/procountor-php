<?php
namespace Procountor\Response;

use Procountor\Interfaces\ExtraInfoInterface;

use stdClass;

class ExtraInfo extends AbstractResponse implements ExtraInfoInterface {

    //Indicates if accounting by row is used (true) or not (false). Accounting by row means that a separate ledger transaction is created for each invoice row. ,
    public function getAccountingByRow(): bool
    {
        return $this->data->accountingByRow;
    }

    //Indicates if the unit prices on invoice rows include VAT (true) or not (false).
    public function getUnitPricesIncludeVat(): bool{
        return $this->data->unitPricesIncludeVat;
    }
}
