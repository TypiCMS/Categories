<?php

namespace TypiCMS\Modules\Categories\Facades;

use Illuminate\Support\Facades\Facade;

class Categories extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Categories';
    }
}
