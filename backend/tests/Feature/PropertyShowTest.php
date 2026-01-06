<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyShowTest extends TestCase
{
    use RefreshDatabase;

    public function testShowPropertyReturns200(): void
    {
        $property = Property::factory()->create();

        $res = $this->getJson("/api/properties/{$property->id}");

        $res->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'is_corner',
                    'distance_convenience_store',
                    'sunlight_score',
                    'noise_score',
                    'created_at',
                    'updated_at',
                ],
                'message',
            ])
            ->assertJsonPath('data.id', $property->id);
    }

    public function testShowSoftDeletedPropertyReturns404(): void
    {
        $property = Property::factory()->create();
        $property->delete();

        $res = $this->getJson("/api/properties/{$property->id}");

        $res->assertNotFound();
    }
}
