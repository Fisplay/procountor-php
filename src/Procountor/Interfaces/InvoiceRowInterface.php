<?php

namespace Procountor\Procountor\Interfaces;

interface InvoiceRowInterface extends AbstractResourceInterface
{

    /**
     * Unique identifier for a product.
     * Links the invoice row to a product in the product register.
     * Note that all other fields (name, price, ...) of an invoice row can be
     * modified independently of the information in the product register.
     * @return null|int
     */
    public function getProductId(): ?int;


    /**
     * Product name
     *
     * @return string
     */
    public function getProduct(): string;

    /**
     * Product code
     *
     * @return string
     */
    public function getProductCode(): ?string;

    /**
     * Product quantity
     *
     * @return float
     */
    public function getQuantity(): float;

    /**
     * Product unit
     * Check enum values from InvoiceRow.unit
     *
     * @see https://dev.procountor.com/api-reference/#model-InvoiceRow
     *
     * @return string
     */
    public function getUnit(): string;

    /**
     * Product unit price. This value is affected by the "unit prices include VAT" setting on the invoice.
     *
     * **IMPORTANT!** Prices are formatted as floats, ie. 5 euros 20 cents = 5.20
     *
     * @see Procountor\Procountor\Interfaces\ExtraInfoInterface
     *
     * @return float
     */
    public function getUnitPrice(): float;

    /**
     * Product discount percentage
     *
     * @return float
     */
    public function getDiscountPercent(): float;

    /**
     * Product VAT percentage. Must be a percentage currently in use for the company.
     *
     * @return int
     */
    public function getVatPercent(): int;

    /**
     * Invoice row comment. Visible on the invoice. Use \ as line break. Max length 25
     *
     * @return null|string
     */
    public function getComment(): ?string;
}
