<?php

namespace Procountor\Procountor\Interfaces;

use DateTime;

interface BusinessPartnerPaymentInfoInterface extends AbstractResourceInterface
{
    //Payment term days.
    public function getPaymentTermDays(): ?string;

    //Payment term percentage.
    public function getPaymentTermPercentage(): ?float;

    //Penal interest rate.
    public function getPenalInterestRate(): ?float;

    //Discount percentage.
    public function getDiscountPercentage(): ?float;

    //Cash discount days.
    public function getCashDiscountDays(): ?string;

    //Cash discount percentage.
    public function getCashDiscountPercentage(): ?float;

    //Payment bank account.
    public function getBankAccount(): ?string;

    //Payment bank account BIC.
    public function getBic(): ?string;

    //['BANK_TRANSFER', 'DIRECT_DEBIT', 'DIRECT_PAYMENT', 'CLEARING', 'CREDIT_CARD_CHARGE', 'FOREIGN_PAYMENT', 'OTHER', 'CASH', 'DOMESTIC_PAYMENT_PLUSGIRO', 'DOMESTIC_PAYMENT_BANKGIRO', 'DOMESTIC_PAYMENT_CREDITOR', 'DKLMPKRE', 'NETS'],
    public function getPaymentMethod(): string;

    //Currency of the payment in ISO 4217 format. Example: EUR. ,
    public function getCurrency(): ?string;
}
