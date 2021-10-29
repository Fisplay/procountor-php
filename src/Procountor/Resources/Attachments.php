<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Collection\AttachmentCollection;
use Procountor\Procountor\Interfaces\Read\Attachment as AttachmentIn;
use Procountor\Procountor\Response\Attachment as AttachmentOut;

class Attachments extends AbstractResourceRequest
{

    protected string $apiPath = 'attachments';
    protected string $interfaceIn = AttachmentIn::class;
    protected string $interfaceOut = AttachmentOut::class;
    protected string $collectionType = AttachmentCollection::class;

}
