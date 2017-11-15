<?php
namespace Procountor\Collection;

use Procountor\Interfaces\AttachmentInterface;

class AttachmentCollection extends AbstractCollection {
    public function addItem(AttachmentInterface $item): AbstractCollection
    {
        $this->addItemToCollection($item);
        return $this;
    }

}
