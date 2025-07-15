<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Daily extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'daily';
    }
}
