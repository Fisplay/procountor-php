<?php

namespace Procountor\Procountor\Interfaces;


interface ListResult
{

    /**
     * Total number of items matching the query.
     *
     * @return int
     */
    public function getTotal(): int;

    /**
     * Current page of paginated results.
     *
     * @return int
     */
    public function getCurrentPage(): int;

    /**
     * Number of items/page on paginated results.
     *
     * @return int
     */
    public function getItemsPerPage(): int;

}
