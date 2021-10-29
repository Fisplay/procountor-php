<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Interfaces\Read\BusinessPartner as BusinessPartnerIn;
use Procountor\Procountor\Response\BusinessPartner as BusinessPartnerOut;


class BusinessPartners extends AbstractResourceRequest
{

    protected static string $apiPath = 'businesspartners';
    protected static string $interfaceIn = BusinessPartnerIn::class;
    protected static string $interfaceOut = BusinessPartnerOut::class;

}
