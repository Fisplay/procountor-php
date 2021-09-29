<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\BankAccountInterface;
use Procountor\Procountor\Interfaces\PaymentInfoInterface;
use DateTime;


/**
 * class PaymentInfo
 *
 * @see https://dev.procountor.com/api-reference/#model-PaymentInfo
 *
 * @package Procountor\Procountor\Response
 */
class PaymentInfo extends AbstractResponse implements PaymentInfoInterface
{

    public function getPaymentMethod(): string
    {
        return $this->data->paymentMethod;
    }

    public function getCurrency(): string
    {
        return $this->data->currency;
    }

    public function getBankReferenceCode(): ?string
    {
        return $this->data->bankReferenceCode ?? null;
    }

    public function getBankAccount(): ?BankAccountInterface
    {
        if (!isset($this->data->bankAccount)) {
            return null;
        }
        return new BankAccount($this->data->bankAccount);
    }

    public function getDueDate(): DateTime
    {
        return new DateTime($this->data->dueDate);
    }

    public function getCurrencyRate(): float
    {
        return $this->data->currencyRate;
    }
}
