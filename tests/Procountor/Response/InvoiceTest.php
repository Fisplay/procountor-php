<?php
namespace Procountor\Response;


use Procountor\Response\Invoice;
use Procountor\Test\ResponseTestBase;

class InvoiceTest extends ResponseTestBase {


    public function testResponseValid() {
        $responsejson = '{
          "id": 0,
          "partnerId": null,
          "type": "SALES_INVOICE",
          "status": "UNFINISHED",
          "date": "2017-11-15",
          "counterParty": {
            "contactPersonName": "string",
            "identifier": "string",
            "taxCode": "string",
            "customerNumber": "string",
            "email": "string",
            "counterPartyAddress": {
              "name": "string",
              "specifier": "string",
              "street": "string",
              "zip": "string",
              "city": "string",
              "country": "SWEDEN"
            },
            "bankAccount": {
              "accountNumber": "string",
              "bic": "string"
            },
            "einvoiceAddress": {
              "operator": "string",
              "address": "string"
            }
          },
          "billingAddress": {
            "name": "string",
            "specifier": "string",
            "street": "string",
            "zip": "string",
            "city": "string",
            "country": "SWEDEN"
          },
          "deliveryAddress": {
            "name": "string",
            "specifier": "string",
            "street": "string",
            "zip": "string",
            "city": "string",
            "country": "SWEDEN"
          },
          "paymentInfo": {
            "paymentMethod": "BANK_TRANSFER",
            "currency": "EUR",
            "referenceCode": "26013",
            "bankAccount": {
              "accountNumber": "string",
              "bic": "string"
            },
            "dueDate": "2017-11-15",
            "currencyRate": 1
          },
          "extraInfo": {
            "accountingByRow": true,
            "unitPricesIncludeVat": true
          },
          "discountPercent": 0,
          "orderReference": "string",
          "invoiceRows": [
            {
              "productId": null,
              "product": "string",
              "productCode": "string",
              "quantity": 0,
              "unit": "CM",
              "unitPrice": 0,
              "discountPercent": 0,
              "vatPercent": 0,
              "comment": "string"
            }
          ],
          "invoiceNumber": 0,
          "originalInvoiceNumber": "string",
          "deliveryStartDate": "2017-11-15",
          "deliveryEndDate": "2017-11-15",
          "deliveryMethod": "MAILING",
          "deliveryInstructions": "string",
          "invoiceChannel": "EMAIL",
          "penaltyPercent": 0,
          "language": "ENGLISH",
          "additionalInformation": "string",
          "vatCountry": "SWEDEN",
          "vatStatus": "1",
          "ledgerReceiptId": null,
          "notes": "string",
          "factoringContractId": null,
          "factoringText": "string",
          "sum": 0,
          "travelInformationItems": [
            {
              "departure": "string",
              "arrival": "string",
              "places": "string",
              "purpose": "string"
            }
          ],
          "attachments": [
            {
              "id": 0,
              "name": "Picture.jpg",
              "referenceType": "INVOICE",
              "referenceId": null,
              "mimeType": "string"
            }
          ]
        }';
        $expectedInvoice = json_decode($responsejson);
        $actualInvoice = new Invoice($expectedInvoice);

        $this->assertProcountorResponseObject($expectedInvoice, $actualInvoice);
    }

}
