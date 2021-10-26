<?php

namespace Procountor\Procountor\Interfaces;

use Procountor\Procountor\Collection\DimensionItemValueCollection;

interface TransactionCommon extends AbstractResourceInterface
{

    //Transaction type. Depends on the transaction and the ledger account in question. Type REVERSING_ENTRY is used to indicate the first row of a ledger receipt for a specific logic on the UI. Typically, it represents a transaction for a balance sheet account. Note that ledger receipts with no transactions marked as reversing entries are possible. Type ENTRY is the general type for transactions. It can be used even on the first rows of ledger receipts. Type RECONCILIATION_ENTRY is used for getting the sum of transactions on a receipt to reconcile (to equal zero). Generally, all ledger receipts should reconcile. Procountor does not automatically create reconciliation entries for ledger receipts created or updated through the API. If VAT is used, a reconciliation row might be necessary due to remainders and rounding. For both REVERSING_ENTRY and RECONCILIATION_ENTRY transactions, vatStatus cannot be defined and vatPercent must be 0. Additionally, transactions of those types cannot be removed from a ledger receipt once created. = ['RECONCILIATION_ENTRY', 'REVERSING_ENTRY', 'ENTRY'],
    public function getTransactionType(): string;

    //Ledger account number for the transaction. Must be valid for the current Procountor environment. Use GET /coa to obtain the chart of accounts. ,
    public function getAccount(): string;

    //Transaction accounting value. Scale: 2. ,
    public function getAccountingValue(): float;

    //Transaction VAT percentage. Must be a percentage currently in use for the company. ,
    public function getVatPercent(): float;

    //Transaction VAT type. = ['SALES', 'PURCHASE'],
    public function getVatType(): ?string;

    //Transaction VAT status. This overrides the VAT status set for the parent ledger receipt. Use here the numeric parts of VAT status codes listed in "VAT defaults" in Procountor. For example, for VAT status code "vat_12", use value 12. The VAT status used must be enabled for the current receipt type (sales/purchase). ,
    public function getVatStatus(): ?int;

    //Transaction description. Visible on ledger receipt printouts. Max length 255. ,
    public function getDescription(): ?string;

    //Transaction balance code. Only available if the use balance sheet setting is enabled. Max length 255. ,
    public function getBalanceCode(): ?string;

    //List of allocation ids related to the transaction. Only for GET cannot be modified through PUT or POST. ,
    public function getAllocations(): ?array;

    //Partner id. Can be provided in Norwegian environments only. The given partner id must match a partner of type different than PERSON, existing in the current Procountor environment. ,
    public function getPartnerId(): ?int;

    //Values of dimension items associated with this transaction. The number of provided dimension items must be within the dimension max count defined by the purchased Procountor license. Provided dimension pairs (dimension id - item id) must be unique within the list provided. ,
    public function getDimensionItemValues(): ?DimensionItemValueCollection;

    //VAT deduction percentage for the transaction.
    public function getVatDeductionPercent(): ?float;
}
