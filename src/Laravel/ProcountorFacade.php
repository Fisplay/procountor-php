<?php

namespace Procountor\Laravel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Procountor\Procountor\Client
 */
class ProcountorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'procountor';
    }
}
