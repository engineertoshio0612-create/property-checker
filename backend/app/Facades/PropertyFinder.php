<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PropertyFinder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\PropertyService::class;
    }
}
