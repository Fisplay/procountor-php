<?php
namespace Procountor\Interfaces;


interface CounterPartyInterface extends AbstractResourceInterface {
    //Name of the contact person. Max length 28. ,
    public function getcontactPersonName(): ?string;

    // SALES_INVOICE only. Business ID or national identification number. ,
    public function getidentifier(): ?string;

    // SALES_INVOICE only. Tax code of the customer. ,
    public function gettaxCode(): ?string;

    // SALES_INVOICE only. Customer number. ,
    public function getcustomerNumber(): ?string;

    // SALES_INVOICE only. Email address of the buyer. Required if invoicing channel is EMAIL, otherwise not visible on the UI. ,
    public function getemail(): string, ?optional;

    // Counterparty address. In the case of a sales invoice this is the buyer's address, and in the case of a purchase invoice it is the seller. Even if the invoice is linked to a business partner by partnerId, the counterparty address can be different from the address saved for that business partner in the partner register. ,
    public function getcounterPartyAddress(): AddressInterface;

    // SALES_INVOICE only. Required if the payment method requires defining the bank accounts for both parties. ,
    public function getbankAccount(): ?BankAccountInterface;

    // SALES_INVOICE only. EInvoice address of the buyer. Required if invoicing channel is ELECTRONIC_INVOICE, otherwise not visible on the UI.
    public function geteinvoiceAddress(): ?EInvoiceAddressInterface;
}
