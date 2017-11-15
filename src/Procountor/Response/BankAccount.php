<?php
namespace Procountor\Response;

use Procountor\Interfaces\BankAccountInterface;

use stdClass;


class BankAccount implements BankAccountInterface {
    private $data;

    public function __construct(stdClass $data) {
        $this->data = $data;
    }

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
