<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Facades\PropertyFinder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PropertyFacadeTest extends TestCase
{
    public function testFacadeCanBeMocked(): void
    {
        // paginate互換のダミーを作る（空でOK）
        $paginator = new LengthAwarePaginator(
            items: new Collection([]),
            total: 0,
            perPage: 10,
            currentPage: 1,
        );

        PropertyFinder::shouldReceive('list')
            ->once()
            ->andReturn($paginator);

        $res = $this->getJson('/api/properties');

        $res->assertOk()
            ->assertJsonPath('meta.total', 0);
    }
}
