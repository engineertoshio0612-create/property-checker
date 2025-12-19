<?php

namespace App\Services;

use App\Models\Property;

class PropertyService
{
    public function list(bool $onlyCorner = true): array
    {
        $query = Property::query();

        if ($onlyCorner) {
            $query->corner();
        }

        return $query
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }
}
