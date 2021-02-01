<?php
namespace Procountor\Interfaces;

use DateTime;

interface BusinessPartnerPaymentInfoInterface extends AbstractResourceInterface {
    //Payment term days.
    function getPaymentTermDays(): ?string;

    //Payment term percentage.
    function getPaymentTermPercentage(): ?float;

    //Penal interest rate.
    function getPenalInterestRate(): ?float;

    //Discount percentage.
    function getDiscountPercentage(): ?float;

    //Cash discount days.
    function getCashDiscountDays(): ?string;

    //Cash discount percentage.
    function getCashDiscountPercentage(): ?float;

    //Payment bank account.
    function getBankAccount(): ?string;

    //Payment bank account BIC.
    function getBic(): ?string;

    //['BANK_TRANSFER', 'DIRECT_DEBIT', 'DIRECT_PAYMENT', 'CLEARING', 'CREDIT_CARD_CHARGE', 'FOREIGN_PAYMENT', 'OTHER', 'CASH', 'DOMESTIC_PAYMENT_PLUSGIRO', 'DOMESTIC_PAYMENT_BANKGIRO', 'DOMESTIC_PAYMENT_CREDITOR', 'DKLMPKRE', 'NETS'],
    function getPaymentMethod(): string;

    //Currency of the payment in ISO 4217 format. Example: EUR. ,
    function getCurrency(): ?string;
}
