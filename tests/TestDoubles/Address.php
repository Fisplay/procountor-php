<?php

namespace Procountor\Tests\TestDoubles;

use Procountor\Procountor\Interfaces\AddressInterface;


class Address extends AbstractBase implements AddressInterface
{

    public function getName(): string
    {
        return $this->faker->name();
    }

    public function getSpecifier(): ?string
    {
        return null;
    }

    public function getStreet(): ?string
    {
        return $this->faker->streetAddress();
    }

    public function getZip(): ?string
    {
        return $this->faker->postcode();
    }

    public function getCity(): ?string
    {
        return $this->faker->city();
    }

    public function getCountry(): ?string
    {
        return $this->faker->country();
    }

}
