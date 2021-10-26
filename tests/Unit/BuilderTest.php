<?php

use Procountor\Procountor\Json\Builder;
use Procountor\Tests\TestResourcePrimary;
use Procountor\Tests\UnitTestCase;

test('build json from TestResource', function () {

    /** @var UnitTestCase $this */

    $builder = new Builder();
    $builder->setResource(new TestResourcePrimary());

    // Parse & compare to avoid annoying differencies in whitespace etc.
    $actual = json_decode($builder->getJson());
    $baseline = json_decode($this->getResponseJson('builder'));

    $this->assertEquals($baseline , $actual);

})->group('builder');
