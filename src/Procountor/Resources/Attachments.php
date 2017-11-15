<?php
namespace Procountor\Resources;

use Procountor\Client;
use Procountor\Interfaces\Read\Attachment as AttachmentIn;
use Procountor\Response\Attachment as AttachmentOut;

class Attachments extends AbstractResourceRequest {
    protected $apiPath = 'attachments';
    protected $interfaceIn = AttachmentIn::class;
    protected $interfaceOut = AttachmentOut::class;



}
