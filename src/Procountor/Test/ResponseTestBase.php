<?php

namespace Procountor\Procountor\Test;

use Procountor\Procountor\Collection\AbstractCollection;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use DateTime;

abstract class ResponseTestBase extends TestCase
{
    protected function assertProcountorResponseObject($data, $object)
    {
        $reflection = new ReflectionClass($object);
        foreach ($reflection->getMethods() as $method) {
            if ($method->name == '__construct' || !preg_match('/get(.*)/', $method->name, $matches)) {
                continue;
            }

            $ret = $object->{$method->name}();
            $field = lcfirst($matches[1]);
            $excepted = $data->{$field};

            switch (gettype($ret)) {
                case 'object':
                    switch (true) {
                        case $ret instanceof AbstractCollection:
                            foreach ($ret as $k => $item) {
                                $this->assertProcountorResponseObject($excepted[$k], $item);
                            }
                            break;
                        case $ret instanceof DateTime:
                            $this->assertEquals(new DateTime($excepted), $ret);
                            break;
                        default:
                            $this->assertProcountorResponseObject($excepted, $ret);
                            break;
                    }

                    break;
                default:
                    $this->assertEquals(
                        $excepted,
                        $ret,
                        sprintf(
                            'Field "%s" of %s value not matching',
                            $field,
                            get_class($object)
                        )
                    );
                    break;
            }
        }
    }
}
