<?php

use Procountor\Procountor\Response\Dimension;
use Procountor\Tests\UnitTestCase;

test('valid dimension json should parse', function () {

    /** @var UnitTestCase $this */

    $json = $this->getResponseJson('dimension');

    $exceptedDimension = json_decode($json);
    $actualDimension = new Dimension($exceptedDimension);

    $this->assertProcountorResponseObject($exceptedDimension, $actualDimension);

})->group('response');
