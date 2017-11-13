<?php
namespace Procountor\Interfaces;

interface ExtraInfoInterface extends AbstractResourceInterface {
    //Indicates if accounting by row is used (true) or not (false). Accounting by row means that a separate ledger transaction is created for each invoice row. ,
    public function getAccountingByRow(): boolean;

    //Indicates if the unit prices on invoice rows include VAT (true) or not (false).
    public function getUnitPricesIncludeVat(): boolean;
}
