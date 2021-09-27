<?php

namespace Procountor\Procountor\Interfaces;

interface AddressInterface extends AbstractResourceInterface
{

    /**
     * Name ("first line") in the address. Max length 80.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Specifier, such as c/o address. Max length 80.
     *
     * @return null|string
     */
    public function getSpecifier(): ?string;

    /**
     * Street.
     * Required for SALES_INVOICE if invoicing channel is MAIL.
     * In that case, must be specified in counterPartyAddress if not specified in billingAddress.
     * Max length 80.
     * @return null|string
     */
    public function getStreet(): ?string;

    /**
     * Zip code. Required for SALES_INVOICE if invoicing channel is MAIL.
     * In that case, must be specified in counterPartyAddress if not specified in billingAddress.
     * Max length 20.
     *
     * @return null|string
     */
    public function getZip(): ?string;


    /**
     * City. Max length 40.
     *
     * @return null|string
     */
    public function getCity(): ?string;

    /**
     * Country.
     * Check enum values from Address.country
     *
     * @see https://dev.procountor.com/api-reference/#model-Address
     *
     *
     * @return null|string
     */
    public function getCountry(): ?string;
}
