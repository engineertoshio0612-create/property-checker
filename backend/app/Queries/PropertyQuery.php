<?php

namespace App\Queries;

use App\Models\Property;
use Illuminate\Database\Eloquent\Builder;

class PropertyQuery
{
    public function build(array $filters = []): Builder
    {
        $query = Property::query();

        if (!empty($filters['corner'])) {
            $query->corner();
        }

        if (!empty($filters['min_sunlight'])) {
            $query->minSunlight($filters['min_sunlight']);
        }

        $query->orderByDesc('id');

        return $query;
    }
}
