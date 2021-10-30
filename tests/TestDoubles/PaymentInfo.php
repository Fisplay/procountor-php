<?php

namespace Procountor\Tests\TestDoubles;

use DateTime;
use Procountor\Procountor\Interfaces\PaymentInfoInterface;


class PaymentInfo extends AbstractBase implements PaymentInfoInterface
{

    public function getPaymentMethod(): string
    {
        return 'BANK_TRANSFER';
    }

    public function getCurrency(): string
    {
        return 'EUR';
    }

    public function getBankReferenceCode(): ?string
    {
        return null;
    }

    public function getBankAccount(): ?BankAccount
    {
        return new BankAccount();
    }

    public function getDueDate(): DateTime
    {
        return new DateTime();
    }

    public function getCurrencyRate(): float
    {
        return 1;
    }

}
