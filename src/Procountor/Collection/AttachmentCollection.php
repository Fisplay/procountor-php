<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\AttachmentCommon;
use TypeError;

class AttachmentCollection extends AbstractCollection
{

    public function __construct(AttachmentCommon ...$items)
    {
        $this->items = $items;
    }

    public function addItem($item): AbstractCollection
    {
        if (!($item instanceof AttachmentCommon)) {
            throw new TypeError('AttachmentCollection expects Attachment instance');
        }

        $this->items[] = $item;
        return $this;
    }

}
