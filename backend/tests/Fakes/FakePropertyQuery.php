<?php

namespace Tests\Fakes;

use App\Queries\PropertyQueryInterface;
use App\Models\Property;
use Illuminate\Database\Eloquent\Builder;

class FakePropertyQuery implements PropertyQueryInterface
{
    public function build(array $filters = []): Builder
    {
        // 実DBに依存しない、固定のクエリを返す
        return Property::query()->whereRaw('1 = 0');
    }
}
