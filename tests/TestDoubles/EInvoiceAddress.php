<?php

namespace Procountor\Tests\TestDoubles;

use Procountor\Procountor\Interfaces\EInvoiceAddressInterface;


class EInvoiceAddress extends AbstractBase implements EInvoiceAddressInterface
{

    public function getOperator(): ?string
    {
        return null;
    }

    public function getAddress(): ?string
    {
        return null;
    }

    public function getEdiId(): ?string
    {
        return null;
    }

}
