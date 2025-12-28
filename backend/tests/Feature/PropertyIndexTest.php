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

    /**
     * corner=0 は「全件」になる
     */
    public function testCornerFilterZeroReturnsAll(): void
    {
        Property::factory()->create(['is_corner' => true]);
        Property::factory()->create(['is_corner' => false]);

        $response = $this->getJson('/api/properties?corner=0');

        $response->assertOk();
        $this->assertCount(2, $response->json('data'));
    }

    /**
     * min_sunlight=1 は「全件」になる（下限境界）
     */
    public function testMinSunlightOneReturnsAll(): void
    {
        Property::factory()->create(['sunlight_score' => 1]);
        Property::factory()->create(['sunlight_score' => 5]);

        $response = $this->getJson('/api/properties?min_sunlight=1');

        $response->assertOk();
        $this->assertCount(2, $response->json('data'));
    }

    /**
     * min_sunlight=5 は「5のみ」になる（上限境界）
     */
    public function testMinSunlightFiveReturnsOnlyFive(): void
    {
        Property::factory()->create(['sunlight_score' => 5]);
        Property::factory()->create(['sunlight_score' => 4]);

        $response = $this->getJson('/api/properties?min_sunlight=5');

        $response->assertOk();

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertSame(5, $data[0]['sunlight_score']);
    }

    /**
     * corner + min_sunlight の複合条件
     */
    public function testCombinedFiltersWork(): void
    {
        // ヒットするのはこれだけ
        Property::factory()->create(['is_corner' => true,  'sunlight_score' => 5]);

        // 角部屋だけど日当たり足りない
        Property::factory()->create(['is_corner' => true,  'sunlight_score' => 3]);

        // 日当たりOKだけど角部屋じゃない
        Property::factory()->create(['is_corner' => false, 'sunlight_score' => 5]);

        $response = $this->getJson('/api/properties?corner=1&min_sunlight=4');

        $response->assertOk();

        $data = $response->json('data');
        $this->assertCount(1, $data);
        $this->assertTrue($data[0]['is_corner']);
        $this->assertGreaterThanOrEqual(4, $data[0]['sunlight_score']);
    }

    /**
     * 物件一覧APIの並び順（新しい順）
     */
    public function testPropertiesAreSortedByIdDesc(): void
    {
        $p1 = Property::factory()->create(); // id小
        $p2 = Property::factory()->create(); // id大

        $response = $this->getJson('/api/properties');

        $response->assertOk();

        $ids = array_column($response->json('data'), 'id');

        $this->assertSame([$p2->id, $p1->id], array_slice($ids, 0, 2));
    }
}
