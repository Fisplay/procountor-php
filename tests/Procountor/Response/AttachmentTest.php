<?php
namespace Procountor\Response;


use Procountor\Response\Attachment;
use Procountor\Collection\AbstractCollection;
use Procountor\Test\ResponseTestBase;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use DateTime;

class AttachmentTest extends ResponseTestBase {

    public function testResponseValid() {
        $json = '{
          "id": 0,
          "name": "Picture.jpg",
          "referenceType": "INVOICE",
          "referenceId": 0,
          "mimeType": "string"
        }';
        $attachmentParsed = json_decode($json);
        $attachment = new Attachment($attachmentParsed);

        $this->assertObject($attachment, $attachmentParsed);
    }

}
