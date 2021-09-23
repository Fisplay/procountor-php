<?php

namespace Procountor\Procountor\Json;

use DateTime;
use Procountor\Procountor\Interfaces\AbstractResourceInterface;
use Procountor\Procountor\Collection\AbstractCollection;
use ReflectionClass;
use ReflectionMethod;

class Builder
{
    private $resource;

    public function __construct()
    {
    }

    public function setResource(AbstractResourceInterface $resource)
    {
        $this->resource = $resource;
    }

    public function getArray()
    {
        $reflection = new ReflectionClass($this->resource);
        $jsonArray = [];

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if (strpos($method->name, 'get') === false) {
                continue;
            }

            $methodname = $method->name;
            $methodreturn = $this->resource->$methodname();

            //We dont want nulls to json
            if ($methodreturn === null) {
                continue;
            }

            $methodReturnObj = (object)$methodreturn;

            switch (true) {
                case $methodReturnObj instanceof DateTime:
                    $value = $this->handleDateTime($methodreturn);
                    break;
                case $methodReturnObj instanceof AbstractResourceInterface:
                    $value = $this->handleResource($methodreturn);
                    break;
                case $methodReturnObj instanceof AbstractCollection:
                    $value = $this->handleCollection($methodreturn);
                    break;
                default:
                    $value = $methodreturn;
                    break;
            }

            $jsonArray[$this->methodToField($methodname)] = $value;
        }

        return $jsonArray;
    }

    public function getJson()
    {
        return json_encode($this->getArray());
    }

    public function methodToField($methodname)
    {
        return lcfirst(str_replace('get', '', $methodname));
    }

    private function handleResource(AbstractResourceInterface $object)
    {
        $builder = new self();
        $builder->setResource($object);
        return $builder->getArray();
    }


    private function handleDateTime(DateTime $datetime)
    {
        return $datetime->format('Y-m-d');
    }

    private function handleCollection(AbstractCollection $collection): array
    {
        $ret = [];
        foreach ($collection as $object) {
            $builder = new self();
            $builder->setResource($object);
            $ret[] = $builder->getArray();
        }
        return $ret;
    }
}
