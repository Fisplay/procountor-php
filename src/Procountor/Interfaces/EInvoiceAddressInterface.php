<?php

namespace Procountor\Procountor\Interfaces;

interface EInvoiceAddressInterface extends AbstractResourceInterface
{

    /**
     * **SALES_INVOICE Only**
     *
     * Operator code.
     * Required if the invoiceChannel is ELECTRONIC_INVOICE and country is FINLAND.
     *
     * @return null|string
     */
    public function getOperator(): ?string;

    /**
     * **SALES_INVOICE Only**
     *
     * EInvoice Address.
     * Required if the invoiceChannel is ELECTRONIC_INVOICE, format must be valid for the specified country.
     *
     * @return null|string
     */
    public function getAddress(): ?string;

    /**
     * **SALES_INVOICE Only**
     *
     * EDI identifier. Used if the invoiceChannel is ELECTRONIC_INVOICE and country is FINLAND.
     *
     * @return null|string
     */
    public function getEdiId(): ?string;
}
