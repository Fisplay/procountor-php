<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\EInvoiceAddressInterface;

class EInvoiceAddress extends AbstractResponse implements EInvoiceAddressInterface
{

    public function getOperator(): ?string
    {
        return $this->data->operator;
    }

    public function getAddress(): ?string
    {
        return $this->data->address;
    }

    public function getEdiId(): ?string
    {
        return $this->data->ediId ?? null;
    }
}
