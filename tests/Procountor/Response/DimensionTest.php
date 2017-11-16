<?php
namespace Procountor\Response;


use Procountor\Response\Dimension;
use Procountor\Test\ResponseTestBase;

class DimensionTest extends ResponseTestBase {

    public function testResponseValid() {
        $jsonresponse = '{
          "id": 0,
          "name": "string",
          "items": [
            {
              "id": 0,
              "codeName": "string",
              "status": "string",
              "description": "string"
            }
          ]
        }';

        $exceptedDimension = json_decode($jsonresponse);
        $actualDimension = new Dimension($exceptedDimension);

        $this->assertProcountorResponseObject($exceptedDimension, $actualDimension);
    }

}
