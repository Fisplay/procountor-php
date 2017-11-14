<?php
namespace Procountor\Interfaces;

interface EInvoiceAddressInterface extends AbstractResourceInterface {
    //SALES_INVOICE Only. Operator code. Required if the invoiceChannel is ELECTRONIC_INVOICE and country is FINLAND. ,
    public function getOperator(): ?string;

    //SALES_INVOICE Only. EInvoice Address. Required if the invoiceChannel is ELECTRONIC_INVOICE, format must be valid for the specified country.
    public function getAddress(): ?string;
}
