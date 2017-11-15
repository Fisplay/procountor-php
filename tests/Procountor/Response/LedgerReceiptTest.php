<?php
namespace Procountor\Response;


use Procountor\Response\LedgerReceipt;
use Procountor\Test\ResponseTestBase;

class LedgerReceiptTest extends ResponseTestBase {

    public function testResponseValid() {
        $jsonresponse = '{
          "receiptId": 0,
          "type": "JOURNAL",
          "status": "EMPTY",
          "name": "string",
          "receiptDate": "2017-11-15",
          "vatType": "SALES",
          "vatStatus": 0,
          "vatProcessing": "SWEDEN",
          "invoiceId": 0,
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
              "transactionId": 0,
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
              "partnerId": 0,
              "dimensionItemValues": [
                {
                  "dimensionId": 0,
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
              "referenceId": 0,
              "mimeType": "string"
            }
          ]
        }';

        $exceptedLedgerReceipt = json_decode($jsonresponse);
        $actualLedgerReceipt = new LedgerReceipt($exceptedLedgerReceipt);

        $this->assertProcountorResponseObject($exceptedLedgerReceipt, $actualLedgerReceipt);
    }

}
