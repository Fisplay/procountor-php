<?php
namespace Procountor\Resources;

use Procountor\Client;
use Procountor\Interfaces\Read\BusinessPartner as BusinessPartnerIn;
use Procountor\Response\BusinessPartner as BusinessPartnerOut;

class BusinessPartners extends AbstractResourceRequest {
    protected $apiPath = 'businesspartners';
    protected $interfaceIn = BusinessPartnerIn::class;
    protected $interfaceOut = BusinessPartnerOut::class;
}
