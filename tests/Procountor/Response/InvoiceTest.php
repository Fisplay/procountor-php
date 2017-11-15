<?php
namespace Procountor\Response;

use Procountor\Response\Invoice;
use Procountor\Collection\AbstractCollection;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use DateTime;

class InvoiceTest extends TestCase {

    public function testResponseValid() {
        $json = '{
          "id": 0,
          "partnerId": 0,
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
              "productId": 0,
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
          "ledgerReceiptId": 0,
          "notes": "string",
          "factoringContractId": 0,
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
              "referenceId": 0,
              "mimeType": "string"
            }
          ]
        }';
        $invoiceParsed = json_decode($json);
        $invoice = new Invoice($invoiceParsed);

        $this->assertObject($invoice, $invoiceParsed);
    }

    private function assertObject($object, $data) {
        $reflection = new ReflectionClass($object);
        foreach ($reflection->getMethods() as $method) {
            if ($method->name=='__construct' || !preg_match('/get(.*)/', $method->name, $matches)) {
                continue;
            }

            $ret = $object->{$method->name}();
            $field = lcfirst($matches[1]);
            $excepted = $data->{$field};

            switch(gettype($ret)) {
                case 'object':
                    switch(true) {
                        case $ret instanceof AbstractCollection:
                            foreach($ret AS  $k => $item) {
                                $this->assertObject($item, $excepted[$k]);
                            }
                        break;
                        case $ret instanceof DateTime:
                            $this->assertEquals(new DateTime($excepted), $ret);
                        break;
                        default:
                            $this->assertObject($ret, $excepted);
                        break;
                    }

                break;
                default:
                    $this->assertEquals(
                        $excepted,
                        $ret,
                        sprintf(
                            'Field %s of %s value not matching',
                            $field,
                            get_class($object)
                        )
                    );
                break;
            }
            //var_dump();
        }
    }
}
