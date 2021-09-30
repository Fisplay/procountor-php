<?php

namespace Procountor\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Procountor\Procountor\Resources\Invoices as InvoicesResource;

/**
 * @see \Procountor\Procountor\Resources\Invoices
 */
class Invoices extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return InvoicesResource::class;
    }
}
