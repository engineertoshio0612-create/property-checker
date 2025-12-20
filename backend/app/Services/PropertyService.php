<?php

namespace App\Services;

use App\Models\Property;

class PropertyService
{
    public function list(array $filters = []): array
    {
        $query = Property::query();

        if (!empty($filters['corner'])) {
            $query->corner();
        }

        if (!empty($filters['min_sunlight'])) {
            $query->minSunlight((int) $filters['min_sunlight']);
        }

        return $query
            ->orderByDesc('id')
            ->get()
            ->toArray();
    }
}
