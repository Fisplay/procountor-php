<?php
namespace Procountor\Response;

use Procountor\Interfaces\BankAccountInterface;
use Procountor\Interfaces\EInvoiceAddressInterface;

use DateTime;
use stdClass;


class EInvoiceAddress implements EInvoiceAddressInterface {
    private $data;

    public function __construct(stdClass $data) {
        $this->data = $data;
    }

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
