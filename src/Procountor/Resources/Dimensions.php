<?php
namespace Procountor\Resources;

use Procountor\Client;
use Procountor\Interfaces\DimensionInterface;
use Procountor\Response\Dimension as DimensionOut;

class Dimensions extends AbstractResourceRequest {
    protected $apiPath = 'dimensions';
    protected $interfaceIn = DimensionInterface::class;
    protected $interfaceOut = DimensionOut::class;
}
