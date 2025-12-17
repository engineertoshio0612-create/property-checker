<?php

namespace App\Services;

use App\Models\Property;

class PropertyService
{
    public function list(): array
    {
        return Property::query()
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }
}
