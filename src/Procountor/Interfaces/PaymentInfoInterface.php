<?php
namespace Procountor\Interfaces;

use DateTime;

interface PaymentInfoInterface extends AbstractResourceInterface {
    //['BANK_TRANSFER', 'DIRECT_DEBIT', 'DIRECT_PAYMENT', 'CLEARING', 'CREDIT_CARD_CHARGE', 'FOREIGN_PAYMENT', 'OTHER', 'CASH', 'DOMESTIC_PAYMENT_PLUSGIRO', 'DOMESTIC_PAYMENT_BANKGIRO', 'DOMESTIC_PAYMENT_CREDITOR', 'DKLMPKRE', 'NETS'],
    function getPaymentMethod(): string;

    //Currency of the payment in ISO 4217 format. Example: EUR. ,
    function getCurrency(): string;

    //Payment reference code. If specified, must be a valid reference code, if not specified the code will be automatically generated. The last digit is a check digit. ,
    function getBankReferenceCode(): ?string;

    //Payment bank account. Not required if payment method is cash. ,
    function getBankAccount(): ?BankAccountInterface;

    //Payment due date. ,
    function getDueDate(): DateTime;

    //Currency exchange rate. Calculated as the amount of one unit of domestic currency in foreign currency. Only foreign currency payments should have a value other than 1.
    function getCurrencyRate(): float;
}
