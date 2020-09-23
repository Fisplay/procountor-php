<?php
namespace Procountor\Response;


use Procountor\Response\LedgerReceipt;
use Procountor\Test\ResponseTestBase;

class LedgerReceiptTest extends ResponseTestBase {

    public function testResponseValid() {
        $jsonresponse = '{
          "receiptId": null,
          "type": "JOURNAL",
          "status": "EMPTY",
          "name": "string",
          "receiptDate": "2017-11-15",
          "vatType": "SALES",
          "vatStatus": 0,
          "vatProcessing": "SWEDEN",
          "invoiceId": null,
          "invoiceNotes": "string",
          "invoiceNumber": 0,
          "accountantsNotes": "string",
          "transactionDescription": "string",
          "receiptValidity": "EMPTY",
          "periodStartDate": "2017-11-15",
          "periodEndDate": "2017-11-15",
          "partnerCode": "string",
          "version": "2017-11-15T07:01:10.382Z",
          "depreciation": "EMPTY",
          "vatDate": "2017-11-15",
          "transactions": [
            {
              "id": 0,
              "transactionType": "RECONCILIATION_ENTRY",
              "account": "string",
              "accountingValue": 0,
              "vatPercent": 0,
              "vatType": "SALES",
              "vatStatus": 0,
              "description": "string",
              "balanceCode": "string",
              "allocations": [
                0
              ],
              "partnerId": null,
              "dimensionItemValues": [
                {
                  "dimensionId": null,
                  "itemId": 0,
                  "value": 0
                }
              ],
              "vatDeductionPercent": 0
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

        $exceptedLedgerReceipt = json_decode($jsonresponse);
        $actualLedgerReceipt = new LedgerReceipt($exceptedLedgerReceipt);

        $this->assertProcountorResponseObject($exceptedLedgerReceipt, $actualLedgerReceipt);
    }

}
