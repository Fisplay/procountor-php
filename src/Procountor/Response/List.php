<?php
namespace Procountor\Response;

abstract class List extends AbstractResponse {

    abstract public function getItems(): array;
}
