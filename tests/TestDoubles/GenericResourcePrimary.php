<?php

namespace Procountor\Tests\TestDoubles;

use DateTime;
use Procountor\Procountor\Collection\AbstractCollection;
use Procountor\Procountor\Interfaces\AbstractResourceInterface;


class GenericResourcePrimary implements AbstractResourceInterface
{

    public function getTestDate(): DateTime
    {
        return new DateTime('2021-01-01 11:22:33');
    }

    public function getTestNull(): ?string
    {
        return null;
    }

    public function getTestAnotherResource(): ?AbstractResourceInterface
    {
        return new GenericResourceSecondary();
    }

    public function getTestString(): string
    {
        return 'This is a test.';
    }

    public function getTestInt(): int
    {
        return 123456;
    }

    public function getTestCollection(): AbstractCollection
    {
        return new Collection(...array_fill(0, 5, new GenericResourceSecondary()));
    }

}
