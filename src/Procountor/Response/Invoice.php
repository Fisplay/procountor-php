<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\Read\Invoice as InvoiceRead;
use Procountor\Procountor\Interfaces\AddressInterface;
use Procountor\Procountor\Interfaces\CounterPartyInterface;
use Procountor\Procountor\Interfaces\PaymentInfoInterface;
use Procountor\Procountor\Interfaces\ExtraInfoInterface;
use Procountor\Procountor\Collection\AttachmentCollection;
use Procountor\Procountor\Collection\InvoiceRowCollection;
use Procountor\Procountor\Collection\TravelInformationItemsCollection;
use DateTime;
use stdClass;
use TypeError;

/**
 * class Invoice
 *
 * This class represents the returned Invoice object.
 * @see https://dev.procountor.com/api-reference/#model-Invoice
 *
 * @package Procountor\Procountor\Response
 */
class Invoice extends AbstractResponse implements InvoiceRead
{

    public function getId(): int
    {
        return $this->data->id;
    }

    public function getInvoiceNumber(): int
    {
        return $this->data->invoiceNumber;
    }

    public function getLedgerReceiptId(): ?int
    {
        return $this->data->ledgerReceiptId;
    }

    public function getSum(): ?string
    {
        return $this->data->sum;
    }

    public function getAttachments(): ?AttachmentCollection
    {
        if (empty($this->data->attachments)) {
            return null;
        }
        return new AttachmentCollection(...array_map(
            fn (stdClass $data): Attachment => new Attachment($data),
            $this->data->attachments
        ));
    }

    public function getPartnerId(): ?int
    {
        return $this->data->partnerId;
    }

    public function getType(): string
    {
        return $this->data->type;
    }

    public function getStatus(): string
    {
        return $this->data->status;
    }

    public function getDate(): DateTime
    {
        return new DateTime($this->data->date);
    }

    public function getCounterParty(): CounterPartyInterface
    {
        return new CounterParty($this->data->counterParty);
    }

    public function getBillingAddress(): ?AddressInterface
    {
        return new Address($this->data->billingAddress);
    }

    public function getDeliveryAddress(): ?AddressInterface
    {
        return new Address($this->data->deliveryAddress);
    }

    public function getPaymentInfo(): PaymentInfoInterface
    {
        return new PaymentInfo($this->data->paymentInfo);
    }

    public function getExtraInfo(): ExtraInfoInterface
    {
        return new ExtraInfo($this->data->extraInfo);
    }

    public function getDiscountPercent(): float
    {
        return $this->data->discountPercent;
    }

    public function getOrderReference(): string
    {
        return $this->data->orderReference;
    }

    public function getInvoiceRows(): ?InvoiceRowCollection
    {
        if (empty($this->data->invoiceRows)) {
            return null;
        }
        return new InvoiceRowCollection(...array_map(
            fn ($row) => new InvoiceRow($row),
            $this->data->invoiceRows
        ));
    }

    public function getOriginalInvoiceNumber(): ?string
    {
        return $this->data->originalInvoiceNumber ?: null;
    }

    public function getDeliveryStartDate(): ?string
    {
        return $this->data->deliveryStartDate;
    }

    public function getDeliveryEndDate(): ?string
    {
        return $this->data->deliveryEndDate;
    }

    public function getDeliveryMethod(): ?string
    {
        return $this->data->deliveryMethod;
    }

    public function getDeliveryInstructions(): ?string
    {
        return $this->data->deliveryInstructions;
    }

    public function getInvoiceChannel(): string
    {
        return $this->data->invoiceChannel;
    }

    public function getPenaltyPercent(): ?float
    {
        return $this->data->penaltyPercent;
    }

    public function getLanguage(): ?string
    {
        return $this->data->language;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->data->additionalInformation;
    }

    public function getVatCountry(): ?string
    {
        return $this->data->vatCountry;
    }

    public function getNotes(): ?string
    {
        return $this->data->notes;
    }

    public function getFactoringContractId(): ?string
    {
        return $this->data->factoringContractId;
    }

    public function getFactoringText(): ?string
    {
        return $this->data->factoringText;
    }

    public function getTravelInformationItems(): ?TravelInformationItemsCollection
    {
        return new TravelInformationItemsCollection(...array_map(
            fn ($item) => new TravelInformationItem($item),
            $this->data->travelInformationItems
        ));
    }

    public function getVatStatus(): int
    {
        return $this->data->vatStatus;
    }
}
