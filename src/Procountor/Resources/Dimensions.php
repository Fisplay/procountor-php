<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Interfaces\DimensionInterface;
use Procountor\Procountor\Response\Dimension as DimensionOut;


class Dimensions extends AbstractResourceRequest
{

    protected static string $apiPath = 'dimensions';
    protected static string $interfaceIn = DimensionInterface::class;
    protected static string $interfaceOut = DimensionOut::class;

}
