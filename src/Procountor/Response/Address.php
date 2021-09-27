<?php

namespace Procountor\Procountor\Response;

use Procountor\Procountor\Interfaces\AddressInterface;

class Address extends AbstractResponse implements AddressInterface
{

    public function getName(): string
    {
        return $this->data->name;
    }

    public function getSpecifier(): ?string
    {
        return $this->data->specifier;
    }

    public function getStreet(): ?string
    {
        return $this->data->street;
    }

    public function getZip(): ?string
    {
        return $this->data->zip;
    }

    public function getCity(): ?string
    {
        return $this->data->city;
    }

    public function getCountry(): ?string
    {
        return $this->data->country;
    }
}
