<?php

namespace Procountor\Tests\TestDoubles;

use Procountor\Procountor\Interfaces\BankAccountInterface;


class BankAccount extends AbstractBase implements BankAccountInterface
{

    public function getAccountNumber(): string
    {
        return $_ENV['PROCOUNTOR_BANK_ACCOUNT'] ?: $this->faker->iban('FI');
    }

    public function getBic(): ?string
    {
        return null;
    }

}
