<?php

namespace Procountor\Procountor\Interfaces;

use DateTime;


/**
 * interface PaymentInfoInterface
 *
 * @see https://dev.procountor.com/api-reference/#model-PaymentInfo
 *
 * @package Procountor\Procountor\Interfaces
 */
interface PaymentInfoInterface extends AbstractResourceInterface
{

    public const PAYMENT_METHOD_BANK_TRANSFER = 'BANK_TRANSFER';
    public const PAYMENT_METHOD_DIRECT_DEBIT = 'DIRECT_DEBIT';
    public const PAYMENT_METHOD_DIRECT_PAYMENT = 'DIRECT_PAYMENT';
    public const PAYMENT_METHOD_CLEARING = 'CLEARING';
    public const PAYMENT_METHOD_CREDIT_CARD_CHARGE = 'CREDIT_CARD_CHARGE';
    public const PAYMENT_METHOD_FOREIGN_PAYMENT = 'FOREIGN_PAYMENT';
    public const PAYMENT_METHOD_OTHER = 'OTHER';
    public const PAYMENT_METHOD_CASH = 'CASH';
    public const PAYMENT_METHOD_DOMESTIC_PAYMENT_PLUSGIRO = 'DOMESTIC_PAYMENT_PLUSGIRO';
    public const PAYMENT_METHOD_DOMESTIC_PAYMENT_BANKGIRO = 'DOMESTIC_PAYMENT_BANKGIRO';
    public const PAYMENT_METHOD_DOMESTIC_PAYMENT_CREDITOR = 'DOMESTIC_PAYMENT_CREDITOR';
    public const PAYMENT_METHOD_DKLMPKRE = 'DKLMPKRE';
    public const PAYMENT_METHOD_NETS = 'NETS';

    /**
     * Payment method. One of:
     * - BANK_TRANSFER
     * - DIRECT_DEBIT
     * - DIRECT_PAYMENT
     * - CLEARING
     * - CREDIT_CARD_CHARGE
     * - FOREIGN_PAYMENT
     * - OTHER
     * - CASH
     * - DOMESTIC_PAYMENT_PLUSGIRO
     * - DOMESTIC_PAYMENT_BANKGIRO
     * - DOMESTIC_PAYMENT_CREDITOR
     * - DKLMPKRE
     * - NETS
     *
     * @return string
     */
    public function getPaymentMethod(): string;

    /**
     * Currency of the payment in ISO 4217 format. Example: EUR.
     *
     * @return string
     */
    public function getCurrency(): string;

    /**
     * Payment reference code. If specified, must be a valid reference code,
     * if not specified the code will be automatically generated.
     * The last digit is a check digit.
     *
     * @return null|string
     */
    public function getBankReferenceCode(): ?string;

    /**
     * Payment bank account. Not required if payment method is cash.
     *
     * @return null|BankAccountInterface
     */
    public function getBankAccount(): ?BankAccountInterface;

    /**
     * Payment due date.
     *
     * @return DateTime
     */
    public function getDueDate(): DateTime;

    /**
     * Currency exchange rate.
     * Calculated as the amount of one unit of domestic currency in foreign currency.
     * Only foreign currency payments should have a value other than 1.
     *
     * @return float
     */
    public function getCurrencyRate(): float;
}
