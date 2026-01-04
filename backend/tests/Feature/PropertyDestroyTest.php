<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyDestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testDeletePropertySoftDeletesRecord(): void
    {
        $property = Property::factory()->create();

        $res = $this->deleteJson("/api/properties/{$property->id}");

        $res->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertSoftDeleted('properties', [
            'id' => $property->id,
        ]);
    }


    public function testSoftDeletedPropertyIsNotListed(): void
    {
        $alive = Property::factory()->create();
        $deleted = Property::factory()->create();
        $deleted->delete();

        $res = $this->getJson('/api/properties');

        $res->assertOk();

        $ids = array_column($res->json('data'), 'id');

        $this->assertCount(1, $ids);
        $this->assertSame([$alive->id], $ids);

        $this->assertSoftDeleted('properties', [
            'id' => $deleted->id,
        ]);

        $this->assertNotNull(Property::withTrashed()->find($deleted->id));
    }
}
