<?php
namespace Procountor\Collection;

use PHPUnit\Framework\TestCase;
use Procountor\Interfaces\AbstractResourceInterface;
use Exception;

class AbstractCollectionTest extends TestCase
{

    public function testAddInvalidItemToCollection()
    {
        $collection = $this->getTestColleciton();

        $this->expectException(Exception::class);
        $collection->addItemToCollection(new \stdClass());

        $this->assertEquals(1, count($collection));
    }

   public function testAddValidItemToCollection()
   {
        $collection = $this->getTestColleciton();

        $collection->addItemToCollection(
            $this->getTestResource()
        );

        $this->assertEquals(1, count($collection));
    }

    public function testLoopThroughCollection()
    {
        $collection = $this->getTestColleciton();


        for($i = 1; $i<=5; $i++) {
            $collection->addItemToCollection(
                $this->getTestResource()
            );
        }

        $this->assertEquals(5, count($collection));

        $counted = 0;
        foreach ($collection as $obj) {
            $counted++;
        }

        $this->assertEquals(5, $counted);
    }


    private function getTestResource()
    {
        return new class() implements AbstractResourceInterface
        {
            public function getA(): string
            {
                return 'A';
            }
        };
    }

    private function getTestColleciton() {
        $collection = new class() extends AbstractCollection
        {

        };

        return $collection;
    }
}
