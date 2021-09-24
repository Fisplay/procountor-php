<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Response\Attachment;
use Procountor\Procountor\Test\ResponseTestBase;

class AttachmentTest extends ResponseTestBase
{

    public function testResponseValid()
    {
        $jsonresponse = '{
          "id": 0,
          "name": "Picture.jpg",
          "referenceType": "INVOICE",
          "referenceId": null,
          "mimeType": "string"
        }';
        $exceptedInvoice = json_decode($jsonresponse);
        $actualInvoice = new Attachment($exceptedInvoice);

        $this->assertProcountorResponseObject($exceptedInvoice, $actualInvoice);
    }
}
