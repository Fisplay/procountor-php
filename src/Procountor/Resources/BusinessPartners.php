<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Interfaces\Read\BusinessPartner as BusinessPartnerIn;
use Procountor\Procountor\Response\BusinessPartner as BusinessPartnerOut;


class BusinessPartners extends AbstractResourceRequest
{
    protected $apiPath = 'businesspartners';
    protected $interfaceIn = BusinessPartnerIn::class;
    protected $interfaceOut = BusinessPartnerOut::class;
}
