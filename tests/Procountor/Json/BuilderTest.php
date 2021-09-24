<?php

namespace Procountor\Procountor\Json;

use PHPUnit\Framework\TestCase;
use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use DateTime;
use Procountor\Procountor\Collection\AbstractCollection;

class BuilderTest extends TestCase
{

    public function testBuild()
    {
        $builder = new Builder();
        $builder->setResource(new class () implements AbstractResourceInterface {
            public function getTestDate(): DateTime
            {
                return new DateTime('2017-07-07 11:22:33');
            }

            public function getTestNull(): ?string
            {
                return null;
            }

            public function getTestAnotherResource(): AbstractResourceInterface
            {
                return new class () implements AbstractResourceInterface {
                    public function getStringOfChild(): string
                    {
                        return "testStringOfChild";
                    }
                };
            }

            public function getTestString(): string
            {
                return 'testString';
            }

            public function getTestInt(): int
            {
                return 123456;
            }

            public function getTestCollection(): AbstractCollection
            {
                $child = new class () implements AbstractResourceInterface {
                    public function getStringOfChild(): string
                    {
                        return "testStringOfChild";
                    }
                };


                $collection = new class () extends AbstractCollection
                {
                    public function addItem(AbstractResourceInterface $item): AbstractCollection
                    {
                        $this->addItemToCollection($item);
                        return $this;
                    }
                };

                for ($i = 1; $i <= 2; $i++) {
                    $collection->addItem($child);
                }
                return $collection;
            }
        });

        $actual = json_decode($builder->getJson(), true);

        $this->assertSame([
            'testDate' => '2017-07-07',
            'testAnotherResource' => ['stringOfChild' => 'testStringOfChild'],
            'testString' => 'testString',
            'testInt' => 123456,
            'testCollection' => [
                0 => ['stringOfChild' => 'testStringOfChild'],
                1 => ['stringOfChild' => 'testStringOfChild'],
            ],
        ], $actual);
    }
}
