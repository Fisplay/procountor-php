<?php
namespace Procountor\Collection;

use Procountor\Interfaces\AttachmentCommon;

class AttachmentCollection extends AbstractCollection {
    public function addItem(AttachmentCommon $item): AbstractCollection
    {
        $this->addItemToCollection($item);
        return $this;
    }

}
