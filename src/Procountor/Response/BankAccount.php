<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\BankAccountInterface;


class BankAccount extends AbstractResponse implements BankAccountInterface
{

    public function getAccountNumber(): string
    {
        return $this->data->accountNumber;
    }

    public function getBic(): ?string
    {
        return $this->data->bic;
    }
}
