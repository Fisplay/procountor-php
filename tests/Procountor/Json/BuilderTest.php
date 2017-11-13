<?php
namespace Procountor\Json;

use PHPUnit\Framework\TestCase;
use Procountor\Interfaces\AbstractResourceInterface;
use DateTime;

class BuilderTest extends TestCase {

    public function testBuild() {
        $builder = new Builder();
        $builder->setResource(new class() implements AbstractResourceInterface {
            public function getDate(): DateTime
            {
                return new DateTime('2017-07-07 11:22:33');
            }

            public function getAnotherResource(): AbstractResourceInterface
            {
                return new class() implements AbstractResourceInterface {
                    public function getStringOfChild(): string
                    {
                        return "testStringOfChild";
                    }
                };

            }

            public function getString(): string
            {
                return 'testString';
            }

            public function getInt(): int
            {
                return 123456;
            }

            public function getArrayOfObjects(): array
            {
                $child = new class() implements AbstractResourceInterface {
                    public function getStringOfChild(): string
                    {
                        return "testStringOfChild";
                    }
                };

                return [
                    $child,
                    $child,
                ];
            }


        });

        $actual = json_decode($builder->getJson(), true);

        $this->assertSame([
            'date' => '2017-07-07',
            'anotherResource' => ['stringOfChild' => 'testStringOfChild'],
            'string' => 'testString',
            'int' => 123456,
            'arrayOfObjects' => [
                0 => ['stringOfChild' => 'testStringOfChild'],
                1 => ['stringOfChild' => 'testStringOfChild'],
            ],
        ], $actual);
    }
}
