<?php

use Procountor\Tests\TestCollection;
use Procountor\Tests\TestResourcePrimary;
use Procountor\Tests\UnitTestCase;


test('adding invalid item throws', function () {

    /** @var UnitTestCase $this */

    $collection = new TestCollection();
    $collection->addItem(new stdClass());

    $this->assertCount(0, $collection);

})->throws(TypeError::class)->group('collection');


test('adding valid item', function () {

    /** @var UnitTestCase $this */

    $collection = new TestCollection();
    $collection->addItem(new TestResourcePrimary());

    $this->assertCount(1, $collection);

})->group('collection');


test('iterating over collection', function() {

    /** @var UnitTestCase $this */

    $collection = new TestCollection(...array_fill(0, 5, new TestResourcePrimary()));

    $this->assertCount(5, $collection);

    $counted = 0;
    foreach ($collection as $resource) {
        $this->assertEquals('This is a test.', $resource->getTestString());
        ++$counted;
    }

    $this->assertEquals(5, $counted);

})->group('collection');
