<?php

namespace App\Services;

use App\Queries\PropertyQuery;

class PropertyService
{
    public function __construct(private PropertyQuery $propertyQuery) {}

    public function list(array $filters = [])
    {
        return $this->propertyQuery
            ->build($filters)
            ->get();
    }
}
