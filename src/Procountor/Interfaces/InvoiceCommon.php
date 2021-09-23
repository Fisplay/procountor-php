<?php

namespace Procountor\Procountor\Interfaces;

use Procountor\Procountor\Collection\InvoiceRowCollection;
use Procountor\Procountor\Collection\TravelInformationItemsCollection;
use DateTime;

interface InvoiceCommon extends AbstractResourceInterface
{

    //Business partner ID. Used to link the invoice to a customer or supplier in the business partner register. If supplied, the company must have this partner ID in the corresponding register. ,
    public function getPartnerId(): ?int;

    //Invoice type. Note that this affects validation requirements. = ['SALES_INVOICE', 'PURCHASE_INVOICE', 'TRAVEL_INVOICE', 'BILL_OF_CHARGES', 'PERIODIC_TAX_RETURN'],
    public function getType(): string;

    //Invoice status. A new invoice created through the API will have its status set as UNFINISHED. = ['EMPTY', 'UNFINISHED', 'NOT_SENT', 'SENT', 'RECEIVED', 'PAID', 'PAYMENT_DENIED', 'VERIFIED', 'APPROVED', 'INVALIDATED', 'PAYMENT_QUEUED', 'PARTLY_PAID', 'PAYMENT_SENT_TO_BANK', 'MARKED_PAID', 'STARTED', 'INVOICED', 'OVERRIDDEN', 'DELETED', 'UNSAVED', 'PAYMENT_TRANSACTION_REMOVED'],
    public function getStatus(): string;

    //Invoice date. This is synonymous to billing date. ,
    public function getDate(): DateTime;

    //This object holds information about the counterparty of the invoice. With sales invoices, it is the buyer. With purchase invoices, it is the seller. With travel and expense invoices, it is the reporter of the expenses. ,
    public function getCounterParty(): ?CounterPartyInterface;

    //The address where the invoice should be sent. If omitted, assumed to equal the counter party address. Note: For purchase invoices, this is the delivery address! In most cases with purchase invoices, supply this parameter with an empty object as value.
    public function getBillingAddress(): ?AddressInterface;

    //The address where the goods should be delivered. If omitted for a sales invoice, assumed to equal the counter party address. Note: This value has no correspondence on the UI with purchase invoices. For defining a delivery address for a purchase invoice, use the billingAddress property instead. ,
    public function getDeliveryAddress(): ?AddressInterface;

    //Invoice payment info. Includes the bank account to which the invoice should be paid, how it should be paid and when it should be paid. ,
    public function getPaymentInfo(): PaymentInfoInterface;

    //Invoice extra info. ,
    public function getExtraInfo(): ExtraInfoInterface;

    //Invoice discount percentage. Scale: 4. ,
    public function getDiscountPercent(): float;

    //Order reference of the invoice. This will be copied to the payment as message if no reference code is specified. Max length 70. ,
    public function getOrderReference(): string;

    //Invoice rows. An invoice should always have at least one row. The only exception are PERIODIC_TAX_RETURN invoices which do not have any invoice rows.
    public function getInvoiceRows(): InvoiceRowCollection;

    //Invoice number from the biller in an external system. Max length 40. ,
    public function getOriginalInvoiceNumber(): ?string;

    //First day of the delivery period. ,
    public function getDeliveryStartDate(): ?string;

    //Last day of the delivery period. ,
    public function getDeliveryEndDate(): ?string;

    //Delivery method for the goods. Sales invoices do not support type OTHER. = ['MAILING', 'ONLINE', 'COURIER', 'VRCARGO', 'BUS', 'RETRIEVABLE', 'OTHER'],
    public function getDeliveryMethod(): ?string;

    //Delivery instructions. Max length 255. ,
    public function getDeliveryInstructions(): ?string;

    //Channel of distribution for the invoice. Values EDIFACT and PAPER_INVOICE are not allowed for new invoices. = ['EMAIL', 'MAIL', 'ELECTRONIC_INVOICE', 'EDIFACT', 'PAPER_INVOICE', 'NO_SENDING']
    public function getInvoiceChannel(): string;

    //Penal interest rate. Scale: 2. ,
    public function getPenaltyPercent(): ?float;

    //Language of the invoice. Required for sales invoices, otherwise ignored. = ['ENGLISH', 'FINNISH', 'SWEDISH', 'ESTONIAN', 'NORWEGIAN', 'DANISH'],
    public function getLanguage(): ?string;

    //Invoice notes containing additional information. Visible on the invoice. Use \n as line break. Max length 10000. ,
    public function getAdditionalInformation(): ?string;

    //Country code describing which country's VAT standards are being used. Usage of foreign VAT settings must be agreed on separately with Procountor. Required if the company uses foreign VATs. Example value: SWEDEN. = ['See Address.country in POST /invoices for a list of allowable values'],
    public function getVatCountry(): ?string;

    //Invoice notes (seller's/buyer's notes). Not visible on the invoice. Use \n as line break. Max length 10000. ,
    public function getNotes(): ?string;

    //SALES_INVOICE only. ID for external financing agreement. The bankAccount.accountNumber specified must match the one used by the specified financing agreement. Financing agreements cannot be used with cash payments. ,
    public function getFactoringContractId(): ?string;

    //SALES_INVOICE only. Additional notes about external financing agreement. ,
    public function getFactoringText(): ?string;

    //Travel information items. Travel invoice may have one or more travel information items containing departure date, return date, destinations and travel purpose. ,
    public function getTravelInformationItems(): ?TravelInformationItemsCollection;

    //VAT status. Use here the numeric parts of VAT status codes listed in "VAT defaults" in Procountor. For example, for VAT status code "vat_12", use value 12.
    public function getVatStatus(): int;
}
