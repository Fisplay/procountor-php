<?php

namespace Procountor\Procountor\Resources;

use Procountor\Procountor\Collection\AttachmentCollection;
use Procountor\Procountor\Interfaces\Read\Attachment as AttachmentIn;
use Procountor\Procountor\Response\Attachment as AttachmentOut;

class Attachments extends AbstractResourceRequest
{

    protected static string $apiPath = 'attachments';
    protected static string $interfaceIn = AttachmentIn::class;
    protected static string $interfaceOut = AttachmentOut::class;
    protected static string $collectionType = AttachmentCollection::class;

}
