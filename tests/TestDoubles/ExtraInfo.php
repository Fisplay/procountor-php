<?php

namespace Procountor\Tests\TestDoubles;

use Procountor\Procountor\Interfaces\ExtraInfoInterface;
use Procountor\Tests\TestDoubles\AbstractBase;


class ExtraInfo extends AbstractBase implements ExtraInfoInterface
{

    public function getAccountingByRow(): bool
    {
        return false;
    }

    public function getUnitPricesIncludeVat(): bool
    {
        return true;
    }

}
