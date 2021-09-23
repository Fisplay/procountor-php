<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\BankAccountInterface;
use Procountor\Procountor\Interfaces\BusinessPartnerPaymentInfoInterface;
use DateTime;
use stdClass;

class BusinessPartnerPaymentInfo extends AbstractResponse implements BusinessPartnerPaymentInfoInterface
{
    //['BANK_TRANSFER', 'DIRECT_DEBIT', 'DIRECT_PAYMENT', 'CLEARING', 'CREDIT_CARD_CHARGE', 'FOREIGN_PAYMENT', 'OTHER', 'CASH', 'DOMESTIC_PAYMENT_PLUSGIRO', 'DOMESTIC_PAYMENT_BANKGIRO', 'DOMESTIC_PAYMENT_CREDITOR', 'DKLMPKRE', 'NETS'],
    function getPaymentMethod(): string
    {
        return $this->data->paymentMethod;
    }

    //Currency of the payment in ISO 4217 format. Example: EUR. ,
    function getCurrency(): ?string
    {
        return $this->data->currency;
    }

    //Bank account.
    function getBankAccount(): ?string
    {
        return $this->data->bankAccount;
    }
    //Bank account BIC.
    function getBic(): ?string
    {
        return $this->data->bic;
    }
    //Payment term days.
    function getPaymentTermDays(): ?string
    {
        return $this->data->paymentTermDays;
    }

    //Payment term percentage.
    function getPaymentTermPercentage(): ?float
    {
        return $this->data->paymentTermPercentage;
    }

    //Penal interest rate.
    function getPenalInterestRate(): ?float
    {
        return $this->data->penalInterestRate;
    }

    //Discount percentage.
    function getDiscountPercentage(): ?float
    {
        return $this->data->discountPercentage;
    }

    //Cash discount days.
    function getCashDiscountDays(): ?string
    {
        return $this->data->cashDiscountDays;
    }

    //Cash discount percentage.
    function getCashDiscountPercentage(): ?float
    {
        return $this->data->cashDiscountPercentage;
    }
}
