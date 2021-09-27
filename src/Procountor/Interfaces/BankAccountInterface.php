<?php

namespace Procountor\Procountor\Interfaces;

interface BankAccountInterface extends AbstractResourceInterface
{
    /**
     * Bank account IBAN.
     * If using a financing agreement, the account number must match the account
     * of the specified financing agreement.
     * The account number must be valid for the specified country.
     *
     * @see https://procountor.finago.com/hc/en-us/articles/360000256077-Implementation-of-bank-connections
     *
     * @return string
     */
    public function getAccountNumber(): string;

    /**
     * **Not supported for SALES_INVOICE and SALES_ORDER.**
     *
     * Bank account BIC/SWIFT.
     *
     * @return null|string
     */
    public function getBic(): ?string;
}
