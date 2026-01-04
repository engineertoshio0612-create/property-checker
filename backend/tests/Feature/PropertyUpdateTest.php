<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testPatchUpdatesOnlySpecifiedFields(): void
    {
        $property = Property::factory()->create([
            'name' => '旧',
            'is_corner' => false,
            'sunlight_score' => 2,
            'noise_score' => 4,
        ]);

        $payload = [
            'sunlight_score' => 5, // これだけ変える
        ];

        $res = $this->patchJson("/api/properties/{$property->id}", $payload);

        $res->assertOk()
            ->assertJsonPath('data.sunlight_score', 5);

        $property->refresh();
        $this->assertSame('旧', $property->name);        // 変わってない
        $this->assertFalse($property->is_corner);        // 変わってない
        $this->assertSame(4, $property->noise_score);    // 変わってない
        $this->assertSame(5, $property->sunlight_score); // 変わった
    }

    public function testPatchWithInvalidSunlightScoreReturns422(): void
    {
        $property = Property::factory()->create();

        $res = $this->patchJson("/api/properties/{$property->id}", [
            'sunlight_score' => 6,
        ]);

        $res->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['sunlight_score'],
            ]);
    }
}
