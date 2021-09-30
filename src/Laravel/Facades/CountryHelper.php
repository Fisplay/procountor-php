<?php

namespace Procountor\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Procountor\Laravel\Helpers\Country;

/**
 * @see \Procountor\Procountor\Resources\Invoices
 */
class CountryHelper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Country::class;
    }
}
