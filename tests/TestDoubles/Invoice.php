<?php

namespace Procountor\Tests\TestDoubles;

use DateTime;
use Procountor\Procountor\Collection\InvoiceRowCollection;
use Procountor\Procountor\Interfaces\InvoiceCommon as InvoiceInterface;
use Procountor\Procountor\Interfaces\Write\Invoice as WriteInvoiceInterface;


class Invoice extends AbstractBase implements WriteInvoiceInterface
{

    public function getPartnerId(): ?int
    {
        return null;
    }

    public function getType(): string
    {
        return 'SALES_INVOICE';
    }

    public function getStatus(): string
    {
        return 'UNFINISHED';
    }

    public function getDate(): DateTime
    {
        return new DateTime();
    }

    public function getCounterParty(): CounterParty
    {
        return new CounterParty();
    }

    public function getBillingAddress(): Address
    {
        return new Address();
    }

    public function getDeliveryAddress(): Address
    {
        return new Address();
    }

    public function getPaymentInfo(): PaymentInfo
    {
        return new PaymentInfo();
    }

    public function getExtraInfo(): ExtraInfo
    {
        return new ExtraInfo();
    }

    public function getDiscountPercent(): float
    {
        return 0;
    }

    public function getOrderReference(): string
    {
        return $this->faker->text(70);
    }

    public function getInvoiceRows(): InvoiceRowCollection
    {
        $itemCount = $this->faker->numberBetween(0, 12);
        return new InvoiceRowCollection(...array_fill(0, $itemCount, new InvoiceRow()));
    }

    public function getOriginalInvoiceNumber(): ?string
    {
        return null;
    }

    public function getDeliveryStartDate(): ?string
    {
        return null;
    }

    public function getDeliveryEndDate(): ?string
    {
        return null;
    }

    public function getDeliveryMethod(): string
    {
        return InvoiceInterface::INVOICE_DELIVERY_METHOD_ONLINE;
    }

    public function getDeliveryInstructions(): ?string
    {
        return null;
    }

    public function getInvoiceChannel(): string
    {
        return InvoiceInterface::INVOICE_CHANNEL_NO_SENDING;
    }

    public function getPenaltyPercent(): ?float
    {
        return 8;
    }

    public function getLanguage(): ?string
    {
        return 'ENGLISH';
    }

    public function getAdditionalInformation(): ?string
    {
       return $this->faker->text(10000);
    }

    public function getVatCountry(): ?string
    {
        return 'FINLAND';
    }

    public function getNotes(): ?string
    {
        return null;
    }

    public function getFactoringContractId(): ?string
    {
        return null;
    }

    public function getFactoringText(): ?string
    {
        return null;
    }

    public function getVatStatus(): int
    {
        // VAT status 1 corresponds to Procountor's default domestic sales/purchases VAT profile
        return 1;
    }
}
