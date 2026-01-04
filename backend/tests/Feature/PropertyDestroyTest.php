<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyDestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testDeletePropertyRemovesRecord(): void
    {
        $property = Property::factory()->create();

        $res = $this->deleteJson("/api/properties/{$property->id}");

        $res->assertOk()
            ->assertJsonStructure(['message']);

        $this->assertDatabaseMissing('properties', [
            'id' => $property->id,
        ]);
    }
}
