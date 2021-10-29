<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Interfaces\Read\BusinessPartner as BusinessPartnerIn;
use Procountor\Procountor\Response\BusinessPartner as BusinessPartnerOut;


class BusinessPartners extends AbstractResourceRequest
{

    protected string $apiPath = 'businesspartners';
    protected string $interfaceIn = BusinessPartnerIn::class;
    protected string $interfaceOut = BusinessPartnerOut::class;

}
