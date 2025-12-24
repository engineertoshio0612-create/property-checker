<?php

namespace Tests\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class PropertyIndexTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = false;
    /**
     * 物件一覧を取得
     */
    public function testGetProperties(): void
    {
        Property::factory()->count(3)->create();

        $response = $this->getJson('/api/properties');

        $response->assertOk()
            ->assertJsonStructure([
                'data',
                'message',
            ]);

        $this->assertCount(3, $response->json('data'));
    }

    /**
     * フィルタで角部屋のみ返却
     */
    public function testFilterCornerProperties(): void
    {
        Property::factory()->create(['is_corner' => true]);
        Property::factory()->create(['is_corner' => false]);

        $response = $this->getJson('/api/properties?corner=1');

        $response->assertOk();

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertTrue($data[0]['is_corner']);
    }

    /**
     * min_sunlightが不正なら422でerrorsを返却
     */
    public function testInvalidMinSunlightReturns422(): void
    {
        $response = $this->getJson('/api/properties?min_sunlight=6');

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['min_sunlight'],
            ]);
    }
}
