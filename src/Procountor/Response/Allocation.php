<?php
namespace Procountor\Response;

use Procountor\Interfaces\Read\Allocation AS AllocationInterface;
use stdClass;

class Allocation implements AllocationInterface {
    private $data;

    public function __construct(stdClass $data) {
        $this->data = $data;
    }

}
