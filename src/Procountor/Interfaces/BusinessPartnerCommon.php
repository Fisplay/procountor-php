<?php
namespace Procountor\Interfaces;

use DateTime;

interface BusinessPartnerCommon extends AbstractResourceInterface {
    //Business partner type. Note that this affects validation requirements. = [ CUSTOMER, SUPPLIER, PERSON ],
    public function getType(): string;

    //The address. If omitted, assumed to equal the counter party address.
    public function getAddress(): ?AddressInterface;

    //The address where the invoice should be sent. If omitted, assumed to equal the counter party address.
    public function getBillingAddress(): ?AddressInterface;

    //The address where the goods should be delivered. If omitted for a sales invoice, assumed to equal the counter party address.
    public function getDeliveryAddress(): ?AddressInterface;

    //Invoice payment info. Includes the bank account to which the invoice should be paid, how it should be paid and when it should be paid. ,
    public function getPaymentInfo(): ?BusinessPartnerPaymentInfoInterface;

    //Name of the partner.
    public function getName(): string;
}
