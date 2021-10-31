<?php

namespace Procountor\Tests\TestDoubles;

use Procountor\Procountor\Interfaces\CounterPartyInterface;
use Procountor\Procountor\Interfaces\EInvoiceAddressInterface;


class CounterParty extends AbstractBase implements CounterPartyInterface
{

    public function getContactPersonName(): ?string
    {
        return $this->faker->name();
    }

    public function getIdentifier(): ?string
    {
        return null;
    }

    public function getTaxCode(): ?string
    {
        return null;
    }

    public function getCustomerNumber(): ?string
    {
        return null;
    }

    public function getEmail(): ?string
    {
        return $this->faker->email();
    }

    public function getCounterPartyAddress(): Address
    {
        return new Address();
    }

    public function getBankAccount(): ?BankAccount
    {
        return null;
    }

    public function getEinvoiceAddress(): ?EInvoiceAddressInterface
    {
        return null;
    }
}
