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

            $methodReturn = $method->invoke($this->resource);

            // We dont want nulls to json
            if ($methodReturn === null) {
                continue;
            }

            switch (true) {
                case $methodReturn instanceof DateTime:
                    $value = $this->handleDateTime($methodReturn);
                    break;
                case $methodReturn instanceof AbstractResourceInterface:
                    $value = $this->handleResource($methodReturn);
                    break;
                case $methodReturn instanceof AbstractCollection:
                    $value = $this->handleCollection($methodReturn);
                    break;
                default:
                    $value = $methodReturn;
                    break;
            }

            $jsonArray[$this->methodToField($method->name)] = $value;
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
