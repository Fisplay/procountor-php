<?php

namespace Procountor\Laravel;

use Illuminate\Support\Facades\Facade;
use Procountor\Procountor\Resources\Invoices;

/**
 * @see \Procountor\Procountor\Client
 */
class ProcountorInvoicesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Invoices::class;
    }
}
