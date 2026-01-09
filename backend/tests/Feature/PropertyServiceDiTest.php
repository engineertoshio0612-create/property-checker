<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\PropertyService;
use App\Queries\PropertyQueryInterface;
use Tests\Fakes\FakePropertyQuery;
use App\Models\Property;

class PropertyServiceDiTest extends TestCase
{
    use RefreshDatabase;

    public function testServiceUsesFakeQueryViaDi(): void
    {
        // 本来ならデータを作っても…
        Property::factory()->count(3)->create();

        // DIをFakeに差し替え
        $this->app->bind(PropertyQueryInterface::class, FakePropertyQuery::class);

        $service = app(PropertyService::class);

        $result = $service->list([]);

        // Fakeは常に空クエリを返す
        $this->assertSame(0, $result->total());
    }
}
