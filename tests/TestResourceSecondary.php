<?php

namespace Procountor\Tests;

use DateTime;
use Procountor\Procountor\Collection\AbstractCollection;
use Procountor\Procountor\Interfaces\AbstractResourceInterface;

class TestResourceSecondary extends TestResourcePrimary
{

    public function getTestDate(): DateTime
    {
        return new DateTime('2021-02-02 11:22:33');
    }

    public function getTestAnotherResource(): ?AbstractResourceInterface
    {
        return null;
    }

    public function getTestString(): string
    {
        return 'This is a test 2.';
    }

    public function getTestInt(): int
    {
        return 654321;
    }

    public function getTestCollection(): AbstractCollection
    {
        return new TestCollection();
    }

}
