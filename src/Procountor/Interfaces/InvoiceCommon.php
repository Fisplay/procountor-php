<?php

namespace Procountor\Procountor\Interfaces;

use Procountor\Procountor\Collection\InvoiceRowCollection;
use Procountor\Procountor\Collection\TravelInformationItemsCollection;
use DateTime;


/**
 * interface InvoiceCommon
 *
 * Holds common fields for write/read invoices.
 * Also defines constants for enum states.
 *
 * @see https://dev.procountor.com/api-reference/#model-Invoice
 * @see Procountor\Procountor\Interfaces\Read\Invoice
 * @see Procountor\Procountor\Interfaces\Write\Invoice
 *
 * @package Procountor\Procountor\Interfaces
 */
interface InvoiceCommon extends AbstractResourceInterface
{

    public const INVOICE_TPYE_SALES_INVOICE = 'SALES_INVOICE';
    public const INVOICE_TPYE_PURCHASE_INVOICE = 'PURCHASE_INVOICE';
    public const INVOICE_TPYE_TRAVEL_INVOICE = 'TRAVEL_INVOICE';
    public const INVOICE_TPYE_BILL_OF_CHARGES = 'BILL_OF_CHARGES';
    public const INVOICE_TPYE_PERIODIC_TAX_RETURN = 'PERIODIC_TAX_RETURN';

    public const INVOICE_STATUS_EMPTY = 'EMPTY';
    public const INVOICE_STATUS_UNFINISHED = 'UNFINISHED';
    public const INVOICE_STATUS_NOT_SENT = 'NOT_SENT';
    public const INVOICE_STATUS_SENT = 'SENT';
    public const INVOICE_STATUS_RECEIVED = 'RECEIVED';
    public const INVOICE_STATUS_PAID = 'PAID';
    public const INVOICE_STATUS_PAYMENT_DENIED = 'PAYMENT_DENIED';
    public const INVOICE_STATUS_VERIFIED = 'VERIFIED';
    public const INVOICE_STATUS_APPROVED = 'APPROVED';
    public const INVOICE_STATUS_INVALIDATED = 'INVALIDATED';
    public const INVOICE_STATUS_PAYMENT_QUEUED = 'PAYMENT_QUEUED';
    public const INVOICE_STATUS_PARTLY_PAID = 'PARTLY_PAID';
    public const INVOICE_STATUS_PAYMENT_SENT_TO_BANK = 'PAYMENT_SENT_TO_BANK';
    public const INVOICE_STATUS_MARKED_PAID = 'MARKED_PAID';
    public const INVOICE_STATUS_STARTED = 'STARTED';
    public const INVOICE_STATUS_INVOICED = 'INVOICED';
    public const INVOICE_STATUS_OVERRIDDEN = 'OVERRIDDEN';
    public const INVOICE_STATUS_DELETED = 'DELETED';
    public const INVOICE_STATUS_UNSAVED = 'UNSAVED';
    public const INVOICE_STATUS_PAYMENT_TRANSACTION_REMOVED = 'PAYMENT_TRANSACTION_REMOVED';

    public const INVOICE_DELIVERY_METHOD_MAILING = 'MAILING';
    public const INVOICE_DELIVERY_METHOD_ONLINE = 'ONLINE';
    public const INVOICE_DELIVERY_METHOD_COURIER = 'COURIER';
    public const INVOICE_DELIVERY_METHOD_VRCARGO = 'VRCARGO';
    public const INVOICE_DELIVERY_METHOD_BUS = 'BUS';
    public const INVOICE_DELIVERY_METHOD_RETRIEVABLE = 'RETRIEVABLE';
    public const INVOICE_DELIVERY_METHOD_OTHER = 'OTHER';

    public const INVOICE_CHANNEL_EMAIL = 'EMAIL';
    public const INVOICE_CHANNEL_MAIL = 'MAIL';
    public const INVOICE_CHANNEL_EDIFACT = 'EDIFACT';
    public const INVOICE_CHANNEL_ELECTRONIC_INVOICE = 'ELECTRONIC_INVOICE';
    public const INVOICE_CHANNEL_PAPER_INVOICE = 'PAPER_INVOICE';
    public const INVOICE_CHANNEL_NO_SENDING = 'NO_SENDING';

    public const INVOICE_LANGUAGE_ENGLISH = 'ENGLISH';
    public const INVOICE_LANGUAGE_FINNISH = 'FINNISH';
    public const INVOICE_LANGUAGE_SWEDISH = 'SWEDISH';
    public const INVOICE_LANGUAGE_ESTONIAN = 'ESTONIAN';
    public const INVOICE_LANGUAGE_NORWEGIAN = 'NORWEGIAN';
    public const INVOICE_LANGUAGE_DANISH = 'DANISH';


    /**
     * Business partner ID.
     * Used to link the invoice to a customer or supplier in the business partner register.
     * If supplied, the company must have this partner ID in the corresponding register.
     *
     * @return null|int
     */
    public function getPartnerId(): ?int;

    /**
     * Invoice type. Note that this affects validation requirements.
     * One of:
     * - SALES_INVOICE
     * - PURCHASE_INVOICE
     * - TRAVEL_INVOICE
     * - BILL_OF_CHARGES
     * - PERIODIC_TAX_RETURN
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Invoice status. A new invoice created through the API will have its status set as UNFINISHED.
     * One of:
     * - EMPTY
     * - UNFINISHED
     * - NOT_SENT
     * - SENT
     * - RECEIVED
     * - PAID
     * - PAYMENT_DENIED
     * - VERIFIED
     * - APPROVED
     * - INVALIDATED
     * - PAYMENT_QUEUED
     * - PARTLY_PAID
     * - PAYMENT_SENT_TO_BANK
     * - MARKED_PAID
     * - STARTED
     * - INVOICED
     * - OVERRIDDEN
     * - DELETED
     * - UNSAVED
     * - PAYMENT_TRANSACTION_REMOVED
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Invoice date. This is synonymous to billing date.
     *
     * @return DateTime
     */
    public function getDate(): DateTime;

    /**
     * This object holds information about the counterparty of the invoice.
     * - With sales invoices, it is the buyer.
     * - With purchase invoices, it is the seller.
     * - With travel and expense invoices, it is the reporter of the expenses.
     * @return null|CounterPartyInterface
     */
    public function getCounterParty(): ?CounterPartyInterface;

    /**
     * The address where the invoice should be sent.
     * If omitted, assumed to equal the counter party address.
     *
     * _Note_: For purchase invoices, this is the delivery address!
     * In most cases with purchase invoices, supply this parameter with an empty object as value.
     *
     * @return null|AddressInterface
     */
    public function getBillingAddress(): ?AddressInterface;

    /**
     * The address where the goods should be delivered.
     * If omitted for a sales invoice, assumed to equal the counter party address.
     *
     * _Note_: This value has no correspondence on the UI with purchase invoices.
     * For defining a delivery address for a purchase invoice, use the billingAddress property instead.
     *
     * @return null|AddressInterface
     */
    public function getDeliveryAddress(): ?AddressInterface;

    /**
     * Invoice payment info.
     * Includes the bank account to which the invoice should be paid,
     * how it should be paid and when it should be paid.
     *
     * @return PaymentInfoInterface
     */
    public function getPaymentInfo(): PaymentInfoInterface;

    /**
     * Invoice extra info
     *
     * @return ExtraInfoInterface
     */
    public function getExtraInfo(): ExtraInfoInterface;

    /**
     * Invoice discount percentage. Scale: 4.
     *
     * @return float
     */
    public function getDiscountPercent(): float;

    /**
     * Order reference of the invoice.
     * This will be copied to the payment as message if no reference code is specified.
     * Max length 70.
     *
     * @return string
     */
    public function getOrderReference(): string;

    /**
     * Invoice rows. An invoice should always have at least one row.
     * The only exception are PERIODIC_TAX_RETURN invoices which do not have any invoice rows.
     *
     * @return InvoiceRowCollection
     */
    public function getInvoiceRows(): InvoiceRowCollection;

    /**
     * Invoice number from the biller in an external system.
     * Max length 40.
     *
     * @return null|string
     */
    public function getOriginalInvoiceNumber(): ?string;

    /**
     * First day of the delivery period.
     *
     * @return null|string
     */
    public function getDeliveryStartDate(): ?string;

    /**
     * Last day of the delivery period.
     *
     * @return null|string
     */
    public function getDeliveryEndDate(): ?string;

    /**
     * Delivery method for the goods.
     * Sales invoices do not support type OTHER.
     * One of:
     * - MAILING
     * - ONLINE
     * - COURIER
     * - VRCARGO
     * - BUS
     * - RETRIEVABLE
     * - OTHER
     *
     * @return null|string
     */
    public function getDeliveryMethod(): ?string;

    /**
     * Delivery instructions. Max length 255.
     *
     * @return null|string
     */
    public function getDeliveryInstructions(): ?string;

    /**
     * Channel of distribution for the invoice.
     * Values EDIFACT and PAPER_INVOICE are not allowed for new invoices.
     * One of:
     * - EMAIL
     * - MAIL
     * - ELECTRONIC_INVOICE
     * - EDIFACT
     * - PAPER_INVOICE
     * - NO_SENDING
     *
     * @return string
     */
    public function getInvoiceChannel(): string;

    /**
     * Penal interest rate. Scale: 2.
     *
     * @return null|float
     */
    public function getPenaltyPercent(): ?float;

    /**
     * Language of the invoice. Required for sales invoices, otherwise ignored.
     * One of:
     * - ENGLISH
     * - FINNISH
     * - SWEDISH
     * - ESTONIAN
     * - NORWEGIAN
     * - DANISH
     *
     * @return null|string
     */
    public function getLanguage(): ?string;

    /**
     * Invoice notes containing additional information. Visible on the invoice.
     * Use \n as line break. Max length 10000.
     *
     * @return null|string
     */
    public function getAdditionalInformation(): ?string;

    /**
     * Country code describing which country's VAT standards are being used.
     * Usage of foreign VAT settings must be agreed on separately with Procountor.
     * Required if the company uses foreign VATs.
     * See Address.country in POST /invoices for a list of allowable values.
     *
     * @see https://dev.procountor.com/api-reference/#operations-Invoices-saveInvoice
     *
     * @return null|string
     */
    public function getVatCountry(): ?string;

    /**
     * Invoice notes (seller's/buyer's notes). Not visible on the invoice.
     * Use \n as line break.
     * Max length 10000.
     *
     * @return null|string
     */
    public function getNotes(): ?string;

    /**
     * **SALES_INVOICE only**
     *
     * ID for external financing agreement.
     * The bankAccount.accountNumber specified must match the one used by the specified financing agreement.
     * Financing agreements cannot be used with cash payments.
     *
     * @return null|string
     */
    public function getFactoringContractId(): ?string;

    /**
     * **SALES_INVOICE only**
     *
     * Additional notes about external financing agreement.
     *
     * @return null|string
     */
    public function getFactoringText(): ?string;

    /**
     * Travel information items.
     * Travel invoice may have one or more travel information items containing:
     * - departure date
     * - return date
     * - destinations
     * - travel purpose
     *
     * @return null|TravelInformationItemsCollection
     */
    public function getTravelInformationItems(): ?TravelInformationItemsCollection;

    /**
     * VAT status. Use here the numeric parts of VAT status codes listed in "VAT defaults" in Procountor.
     * For example, for VAT status code "vat_12", use value 12.
     *
     * @see https://dev.procountor.com/api-reference/#model-VatInformation
     *
     * @return int
     */
    public function getVatStatus(): int;
}
