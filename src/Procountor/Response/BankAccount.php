<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\BankAccountInterface;
use stdClass;

class BankAccount extends AbstractResponse implements BankAccountInterface
{

    //Bank account IBAN. If using a financing agreement, the account number must match the account of the specified financing agreement. The account number must be valid for the specified country. See http://support.procountor.com/en/maksuliikenne/pankkiyhteydet.html for more information about adding bank accounts in Procountor. ,
    public function getAccountNumber(): string
    {
        return $this->data->accountNumber;
    }

    //PURCHASE_INVOICE only. Bank account BIC/SWIFT.
    public function getBic(): ?string
    {
        return $this->data->bic;
    }
}
