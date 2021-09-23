<?php

namespace Procountor\Procountor\Interfaces;

interface BankAccountInterface extends AbstractResourceInterface
{
    //Bank account IBAN. If using a financing agreement, the account number must match the account of the specified financing agreement. The account number must be valid for the specified country. See http://support.procountor.com/en/maksuliikenne/pankkiyhteydet.html for more information about adding bank accounts in Procountor. ,
    public function getAccountNumber(): string;

    //PURCHASE_INVOICE only. Bank account BIC/SWIFT.
    public function getBic(): ?string;
}
