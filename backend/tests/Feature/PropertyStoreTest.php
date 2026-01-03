<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyStoreTest extends TestCase
{
    use RefreshDatabase;

    public function testStorePropertyReturns201(): void
    {
        $payload = [
            'name' => 'テスト物件',
            'is_corner' => true,
            'distance_convenience_store' => 300,
            'sunlight_score' => 4,
            'noise_score' => 2,
        ];

        $response = $this->postJson('/api/properties', $payload);

        $response->assertStatus(201)
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
            ]);

        $this->assertDatabaseHas('properties', [
            'name' => 'テスト物件',
            'is_corner' => 1,
            'sunlight_score' => 4,
        ]);

        $this->assertSame('テスト物件', $response->json('data.name'));
    }

    public function testStorePropertyWithInvalidSunlightScoreReturns422(): void
    {
        $payload = [
            'name' => 'テスト物件',
            'is_corner' => true,
            'distance_convenience_store' => 300,
            'sunlight_score' => 6, // NG（max:5）
            'noise_score' => 2,
        ];

        $response = $this->postJson('/api/properties', $payload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['sunlight_score'],
            ]);

        // 失敗したら当然DBに入らないことも確認（地味に効く）
        $this->assertDatabaseMissing('properties', [
            'name' => 'テスト物件',
        ]);
    }
}
