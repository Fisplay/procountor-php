<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\Read\BusinessPartner as BusinessPartnerRead;
use Procountor\Procountor\Interfaces\AddressInterface;
use Procountor\Procountor\Interfaces\PaymentInfoInterface;
use Procountor\Procountor\Interfaces\BusinessPartnerPaymentInfoInterface;
use DateTime;

class BusinessPartner extends AbstractResponse implements BusinessPartnerRead
{
    //Unique identifier of the invoice. Generated by Procountor and present in the object returned. ,
    public function getId(): int
    {
        return $this->data->id;
    }

    //Invoice type. Note that this affects validation requirements. = ['SALES_INVOICE', 'PURCHASE_INVOICE', 'TRAVEL_INVOICE', 'BILL_OF_CHARGES', 'PERIODIC_TAX_RETURN'],
    public function getType(): string
    {
        return $this->data->type;
    }

    //The address where the invoice should be sent. If omitted, assumed to equal the counter party address. Note: For purchase invoices, this is the delivery address! In most cases with purchase invoices, supply this parameter with an empty object as value.
    public function getAddress(): ?AddressInterface
    {
        return new Address($this->data->address);
    }

    //The address where the invoice should be sent. If omitted, assumed to equal the counter party address. Note: For purchase invoices, this is the delivery address! In most cases with purchase invoices, supply this parameter with an empty object as value.
    public function getBillingAddress(): ?AddressInterface
    {
        return new Address($this->data->billingAddress);
    }

    //The address where the goods should be delivered. If omitted for a sales invoice, assumed to equal the counter party address. Note: This value has no correspondence on the UI with purchase invoices. For defining a delivery address for a purchase invoice, use the billingAddress property instead. ,
    public function getDeliveryAddress(): ?AddressInterface
    {
        return new Address($this->data->deliveryAddress);
    }

    //Invoice payment info. Includes the bank account to which the invoice should be paid, how it should be paid and when it should be paid. ,
    public function getPaymentInfo(): ?BusinessPartnerPaymentInfoInterface
    {
        return new BusinessPartnerPaymentInfo($this->data->paymentInfo);
    }

    //Name.
    public function getName(): string
    {
        return $this->data->name;
    }
}
