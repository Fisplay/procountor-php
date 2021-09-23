<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\BankAccountInterface;
use Procountor\Procountor\Interfaces\EInvoiceAddressInterface;
use DateTime;
use stdClass;

class EInvoiceAddress extends AbstractResponse implements EInvoiceAddressInterface
{

    //SALES_INVOICE Only. Operator code. Required if the invoiceChannel is ELECTRONIC_INVOICE and country is FINLAND. ,
    public function getOperator(): ?string
    {
        return $this->data->operator;
    }

    //SALES_INVOICE Only. EInvoice Address. Required if the invoiceChannel is ELECTRONIC_INVOICE, format must be valid for the specified country.
    public function getAddress(): ?string
    {
        return $this->data->address;
    }
}
