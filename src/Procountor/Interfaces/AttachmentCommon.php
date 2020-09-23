<?php
namespace Procountor\Interfaces;

interface AttachmentCommon extends AbstractResourceInterface {

    //Attachment name. Include a correct file extension to the value. ,
    public function getName(): string;

    //Reference type of the attachment. Indicates what object is the owner of the attachment. Exception: for JOURNAL type ledger receipts, use type INVOICE. = ['INVOICE', 'LEDGERRECEIPT', 'BANKSTATEMENTEVENT', 'SALES_PRODUCT_REGISTER', 'PURCHASE_PRODUCT_REGISTER', 'CUSTOMER_BUSINESS_PARTNER_REGISTER', 'SUPPLIER_BUSINESS_PARTNER_REGISTER', 'PERSON_BUSINESS_PARTNER_REGISTER', 'EMPLOYEE_INFO', 'ENVIRONMENT', 'FINANCIAL_STATEMENT', 'NETS_COLLECTION'],
    public function getReferenceType(): string;

    //Unique identifier of the referenced object. Exception: for JOURNAL type ledger receipts, use the value of invoiceId referring to the associated invoice. ,
    public function getReferenceId(): ?string;

}
