<?php

namespace App\Services\Laragram\Laravel;

use Illuminate\Support\Facades\Facade;

class TG extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laragram';
    }
}
