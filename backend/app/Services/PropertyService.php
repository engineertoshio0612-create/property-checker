<?php

namespace App\Services;

use App\Models\Property;
use App\Queries\PropertyQuery;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PropertyService
{
    public function __construct(private PropertyQuery $propertyQuery) {}

    public function list(array $filters = [])
    {
        return $this->propertyQuery
            ->build($filters)
            ->paginate(10);
    }

    public function create(array $payload): Property
    {
        return Property::create($payload);
    }

    public function update(Property $property, array $data): Property
    {
        $property->fill($data);
        $property->save();

        return $property->refresh();
    }

    public function delete(Property $property): void
    {
        $property->delete();
    }

    public function createWithMultipleStepsWithoutTransaction(array $payload): void
    {
        $property = Property::create($payload);

        $property->name = $property->name . '_UPDATED';
        $property->save();

        throw new RuntimeException('ダミー例外（transaction無し）');
    }

    public function createWithMultipleStepsWithTransaction(array $payload): void
    {
        DB::transaction(function () use ($payload) {
            $property = Property::create($payload);

            $property->name = $property->name . '_UPDATED';
            $property->save();

            throw new RuntimeException('ダミー例外（transaction有り）');
        });
    }
}
