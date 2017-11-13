<?php
namespace Procountor\Interfaces;


interface InvoiceRowInterface extends AbstractResourceInterface {

    //Unique identifier for a product. Links the invoice row to a product in the product register. Note that all other fields (name, price, ...) of an invoice row can be modified independently of the information in the product register. ,
    public function getProductId(): ?int;

    //Product Name
    public function getProduct(): string;

    //Product code
    public function getProductCode(): string;

    //Product quantity
    public function getQuantity(): float;

    //Product unit. = ['CM', 'LOT', 'GRAM', 'HOUR', 'PERSON', 'LINEAR_METER', 'KILOGRAM', 'MONTH', 'KILOMETER', 'PIECE', 'KILOWATT_HOUR', 'LITER', 'BOX', 'METER', 'SQUARE_METER', 'CUBIC_METER', 'SALE_UNIT', 'MINUTE', 'MILLIMETER', 'PARCEL', 'BOTTLE', 'CAN', 'BAG', 'DAY', 'ROLL', 'PAGE', 'SACK', 'SERIES', 'TUBE', 'TON', 'YEAR', 'WEEK', 'FULL_DAY', 'NO_UNIT'],
    public function getUnit(): string;

    //Product unit price. This value is affected by the "unit prices include VAT" setting on the invoice. ,
    public function getUnitPrice(): float;

    //Product discount percentage
    public function getDiscountPercent(): float;

    //Product VAT percentage. Must be a percentage currently in use for the company. ,
    public function getVatPercent(): float;

    //Invoice row comment. Visible on the invoice. Use \ as line break. Max length 25
    public function getComment(): ?string;
}
