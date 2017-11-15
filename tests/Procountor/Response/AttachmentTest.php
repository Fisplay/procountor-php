<?php
namespace Procountor\Response;


use Procountor\Response\Attachment;
use Procountor\Test\ResponseTestBase;

class AttachmentTest extends ResponseTestBase {

    public function testResponseValid() {
        $jsonresponse = '{
          "id": 0,
          "name": "Picture.jpg",
          "referenceType": "INVOICE",
          "referenceId": 0,
          "mimeType": "string"
        }';
        $exceptedInvoice = json_decode($jsonresponse);
        $actualInvoice = new Attachment($exceptedInvoice);

        $this->assertProcountorResponseObject($exceptedInvoice, $actualInvoice);
    }

}
