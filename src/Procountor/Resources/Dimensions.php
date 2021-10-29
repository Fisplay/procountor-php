<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Interfaces\DimensionInterface;
use Procountor\Procountor\Response\Dimension as DimensionOut;


class Dimensions extends AbstractResourceRequest
{

    protected $apiPath = 'dimensions';
    protected $interfaceIn = DimensionInterface::class;
    protected $interfaceOut = DimensionOut::class;

}
