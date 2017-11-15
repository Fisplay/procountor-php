<?php
namespace Procountor\Response;

use Procountor\Interfaces\CounterPartyInterface;
use Procountor\Interfaces\AddressInterface;
use Procountor\Interfaces\BankAccountInterface;
use Procountor\Interfaces\EInvoiceAddressInterface;

use stdClass;


class CounterParty extends AbstractResponse implements CounterPartyInterface {

    //Name of the contact person. Max length 28. ,
    public function getContactPersonName(): ?string
    {
        return $this->data->contactPersonName;
    }

    // SALES_INVOICE only. Business ID or national identification number. ,
    public function getIdentifier(): ?string
    {
        return $this->data->identifier;
    }

    // SALES_INVOICE only. Tax code of the customer. ,
    public function getTaxCode(): ?string
    {
        return $this->data->taxCode;
    }

    // SALES_INVOICE only. Customer number. ,
    public function getCustomerNumber(): ?string
    {
        return $this->data->customerNumber;
    }

    // SALES_INVOICE only. Email address of the buyer. Required if invoicing channel is EMAIL, otherwise not visible on the UI. ,
    public function getEmail(): ?string
    {
        return $this->data->email;
    }

    // Counterparty address. In the case of a sales invoice this is the buyer's address, and in the case of a purchase invoice it is the seller. Even if the invoice is linked to a business partner by partnerId, the counterparty address can be different from the address saved for that business partner in the partner register. ,
    public function getCounterPartyAddress(): AddressInterface
    {
        return new Address($this->data->counterPartyAddress);
    }

    // SALES_INVOICE only. Required if the payment method requires defining the bank accounts for both parties. ,
    public function getBankAccount(): ?BankAccountInterface
    {
        return new BankAccount($this->data->bankAccount);
    }

    // SALES_INVOICE only. EInvoice address of the buyer. Required if invoicing channel is ELECTRONIC_INVOICE, otherwise not visible on the UI.
    public function getEinvoiceAddress(): ?EInvoiceAddressInterface
    {
        return new EInvoiceAddress($this->data->einvoiceAddress);
    }

}
