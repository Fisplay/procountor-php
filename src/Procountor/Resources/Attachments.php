<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Interfaces\Read\Attachment as AttachmentIn;
use Procountor\Procountor\Response\Attachment as AttachmentOut;

class Attachments extends AbstractResourceRequest
{
    protected $apiPath = 'attachments';
    protected $interfaceIn = AttachmentIn::class;
    protected $interfaceOut = AttachmentOut::class;
}
