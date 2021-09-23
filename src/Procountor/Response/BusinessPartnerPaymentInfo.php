<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\BankAccountInterface;
use Procountor\Procountor\Interfaces\BusinessPartnerPaymentInfoInterface;
use DateTime;
use stdClass;

class BusinessPartnerPaymentInfo extends AbstractResponse implements BusinessPartnerPaymentInfoInterface
{
    //['BANK_TRANSFER', 'DIRECT_DEBIT', 'DIRECT_PAYMENT', 'CLEARING', 'CREDIT_CARD_CHARGE', 'FOREIGN_PAYMENT', 'OTHER', 'CASH', 'DOMESTIC_PAYMENT_PLUSGIRO', 'DOMESTIC_PAYMENT_BANKGIRO', 'DOMESTIC_PAYMENT_CREDITOR', 'DKLMPKRE', 'NETS'],
    public function getPaymentMethod(): string
    {
        return $this->data->paymentMethod;
    }

    //Currency of the payment in ISO 4217 format. Example: EUR. ,
    public function getCurrency(): ?string
    {
        return $this->data->currency;
    }

    //Bank account.
    public function getBankAccount(): ?string
    {
        return $this->data->bankAccount;
    }
    //Bank account BIC.
    public function getBic(): ?string
    {
        return $this->data->bic;
    }
    //Payment term days.
    public function getPaymentTermDays(): ?string
    {
        return $this->data->paymentTermDays;
    }

    //Payment term percentage.
    public function getPaymentTermPercentage(): ?float
    {
        return $this->data->paymentTermPercentage;
    }

    //Penal interest rate.
    public function getPenalInterestRate(): ?float
    {
        return $this->data->penalInterestRate;
    }

    //Discount percentage.
    public function getDiscountPercentage(): ?float
    {
        return $this->data->discountPercentage;
    }

    //Cash discount days.
    public function getCashDiscountDays(): ?string
    {
        return $this->data->cashDiscountDays;
    }

    //Cash discount percentage.
    public function getCashDiscountPercentage(): ?float
    {
        return $this->data->cashDiscountPercentage;
    }
}
