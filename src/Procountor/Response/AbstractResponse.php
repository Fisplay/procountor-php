<?php
namespace Procountor\Response;

use stdClass;

abstract class AbstractResponse {
    protected $data;

    public function __construct(stdClass $data) {
        $this->data = $data;
    }

    public function __set(string $attribute, $value) {
        if (isset($this->data->$attribute)) {
            $this->data->$attribute = $value;
        }
    }
}
