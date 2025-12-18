<?php

namespace App\Services;

use App\Models\Property;

class PropertyService
{
    public function list(): array
    {
        return Property::query()
            ->corner()
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }
}
