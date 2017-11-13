<?php
namespace Procountor\Json;

use DateTime;
use Procountor\Interfaces\AbstractResourceInterface;
use ReflectionClass;
use ReflectionMethod;

class Builder {
    private $resource;

    public function __construct()
    {

    }

    public function setResource(AbstractResourceInterface $resource)
    {
        $this->resource = $resource;
    }

    private function getArray()
    {
        $reflection = new ReflectionClass($this->resource);
        $jsonArray = [];

        foreach($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $methodname = $method->name;
            $methodreturn = $this->resource->$methodname();
            switch(gettype($methodreturn)) {
                case 'object':
                    $value = $this->handleObject($methodreturn);
                break;
                case 'array':
                    $value = $this->handleArray($methodreturn);
                break;
                default;
                    $value = $methodreturn;
                break;
            }

            $jsonArray[$this->methodToField($methodname)] = $value;

        }

        return $jsonArray;
    }

    public function getJson() {
        return json_encode($this->getArray());
    }

    public function methodToField($methodname)
    {
        return lcfirst(str_replace('get', '', $methodname));
    }

    private function handleObject($object) {
        if ($object instanceof AbstractResourceInterface) {
            $builder = new self();
            $builder->setResource($object);
            return $builder->getArray();
        }

        switch(get_class($object)) {
            case DateTime::class:
                return $object->format('Y-m-d');
            break;
            default:

            throw new \Exception('ei onnaa');
        }
    }

    private function handleArray($array) {
        $ret = [];
        foreach ($array as $object) {
            $builder = new self();
            $builder->setResource($object);
            $ret[] = $builder->getArray();
        }
        return $ret;
    }
}
