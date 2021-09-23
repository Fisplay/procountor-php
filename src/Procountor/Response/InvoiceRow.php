<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\InvoiceRowInterface;
use stdClass;

class InvoiceRow extends AbstractResponse implements InvoiceRowInterface
{

    //Unique identifier for a product. Links the invoice row to a product in the product register. Note that all other fields (name, price, ...) of an invoice row can be modified independently of the information in the product register. ,
    public function getProductId(): ?int
    {
        return $this->data->productId;
    }

    //Product Name
    public function getProduct(): string
    {
        return $this->data->product;
    }
    //Product code
    public function getProductCode(): string
    {
        return $this->data->productCode;
    }

    //Product quantity
    public function getQuantity(): float
    {
        return $this->data->quantity;
    }

    //Product unit. = ['CM', 'LOT', 'GRAM', 'HOUR', 'PERSON', 'LINEAR_METER', 'KILOGRAM', 'MONTH', 'KILOMETER', 'PIECE', 'KILOWATT_HOUR', 'LITER', 'BOX', 'METER', 'SQUARE_METER', 'CUBIC_METER', 'SALE_UNIT', 'MINUTE', 'MILLIMETER', 'PARCEL', 'BOTTLE', 'CAN', 'BAG', 'DAY', 'ROLL', 'PAGE', 'SACK', 'SERIES', 'TUBE', 'TON', 'YEAR', 'WEEK', 'FULL_DAY', 'NO_UNIT'],
    public function getUnit(): string
    {
        return $this->data->unit;
    }

    //Product unit price. This value is affected by the "unit prices include VAT" setting on the invoice. ,
    public function getUnitPrice(): float
    {
        return $this->data->unitPrice;
    }

    //Product discount percentage
    public function getDiscountPercent(): float
    {
        return $this->data->discountPercent;
    }

    //Product VAT percentage. Must be a percentage currently in use for the company. ,
    public function getVatPercent(): int
    {
        return $this->data->vatPercent;
    }

    //Invoice row comment. Visible on the invoice. Use \ as line break. Max length 25
    public function getComment(): ?string
    {
        return $this->data->comment;
    }
}
