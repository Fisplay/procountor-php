<?php

namespace Procountor\Procountor\Interfaces;

interface CounterPartyInterface extends AbstractResourceInterface
{
    /**
     * Name of the contact person. Max length 28.
     *
     * @return null|string
     */
    public function getContactPersonName(): ?string;

    /**
     * **SALES_INVOICE only**
     *
     * Business ID or national identification number.
     *
     * @return null|string
     */
    public function getIdentifier(): ?string;

    /**
     * **SALES_INVOICE only**
     *
     * Tax code of the customer.
     *
     * @return null|string
     */
    public function getTaxCode(): ?string;

    /**
     * **SALES_INVOICE only**
     *
     * Customer number.
     *
     * @return null|string
     */
    public function getCustomerNumber(): ?string;

    /**
     * **SALES_INVOICE only**
     *
     * Email address of the buyer.
     * Required if invoicing channel is EMAIL, otherwise not visible on the UI.
     *
     * @return null|string
     */
    public function getEmail(): ?string;

    /**
     * Counterparty address. In the case of a sales invoice this is the buyer's address,
     * and in the case of a purchase invoice it is the seller.
     * Even if the invoice is linked to a business partner by partnerId,
     * the counterparty address can be different from the address saved for that
     * business partner in the partner register.
     *
     * @return AddressInterface
     */
    public function getCounterPartyAddress(): AddressInterface;

    /**
     * **SALES_INVOICE only**
     *
     * Required if the payment method requires defining the bank accounts for both parties.
     *
     * @return null|BankAccountInterface
     */
    public function getBankAccount(): ?BankAccountInterface;

    /**
     * **SALES_INVOICE only**
     *
     * EInvoice address of the buyer.
     * Required if invoicing channel is ELECTRONIC_INVOICE, otherwise not visible on the UI.
     *
     * @return null|EInvoiceAddressInterface
     */
    public function getEinvoiceAddress(): ?EInvoiceAddressInterface;
}
