<?php
namespace Procountor\Test;

use Procountor\Response\Invoice;
use Procountor\Collection\AbstractCollection;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use DateTime;

abstract class ResponseTestBase extends TestCase {

    protected function assertObject($object, $data) {
        $reflection = new ReflectionClass($object);
        foreach ($reflection->getMethods() as $method) {
            if ($method->name=='__construct' || !preg_match('/get(.*)/', $method->name, $matches)) {
                continue;
            }

            $ret = $object->{$method->name}();
            $field = lcfirst($matches[1]);
            $excepted = $data->{$field};

            switch(gettype($ret)) {
                case 'object':
                    switch(true) {
                        case $ret instanceof AbstractCollection:
                            foreach($ret AS  $k => $item) {
                                $this->assertObject($item, $excepted[$k]);
                            }
                        break;
                        case $ret instanceof DateTime:
                            $this->assertEquals(new DateTime($excepted), $ret);
                        break;
                        default:
                            $this->assertObject($ret, $excepted);
                        break;
                    }

                break;
                default:
                    $this->assertEquals(
                        $excepted,
                        $ret,
                        sprintf(
                            'Field %s of %s value not matching',
                            $field,
                            get_class($object)
                        )
                    );
                break;
            }
            //var_dump();
        }
    }
}
