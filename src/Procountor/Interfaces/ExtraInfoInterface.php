<?php

namespace Procountor\Procountor\Interfaces;


/**
 * interface ExtraInfoInterface
 *
 * @see Procountor\Procountor\Interfaces\ExtraInfoInterface
 * @see https://dev.procountor.com/api-reference/#model-ExtraInfo
 * @package Procountor\Procountor\Interfaces
 */
interface ExtraInfoInterface extends AbstractResourceInterface
{
    /**
     * Indicates if accounting by row is used (true) or not (false).
     * Accounting by row means that a separate ledger transaction is created for each invoice row.
     *
     * @return bool
     */
    public function getAccountingByRow(): bool;

    /**
     * Indicates if the unit prices on invoice rows include VAT (true) or not (false).
     *
     * @return bool
     */
    public function getUnitPricesIncludeVat(): bool;
}
