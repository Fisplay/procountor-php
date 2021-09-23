<?php

namespace Procountor\Procountor\Collection;

use Procountor\Procountor\Interfaces\AttachmentCommon;

class AttachmentCollection extends AbstractCollection
{
    public function addItem(AttachmentCommon $item): AbstractCollection
    {
        $this->addItemToCollection($item);
        return $this;
    }
}
