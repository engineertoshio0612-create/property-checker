<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Property extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\PropertyService::class;
    }
}
