<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyNotFoundTest extends TestCase
{
    use RefreshDatabase;

    public function testShowNonExistingPropertyReturns404Json(): void
    {
        $res = $this->getJson('/api/properties/999999');

        $res->assertNotFound()
            ->assertJson([
                'message' => 'リソースが見つかりません。',
            ]);
    }

    public function testUpdateNonExistingPropertyReturns404Json(): void
    {
        $res = $this->patchJson('/api/properties/999999', [
            'sunlight_score' => 5,
        ]);

        $res->assertNotFound()
            ->assertJson([
                'message' => 'リソースが見つかりません。',
            ]);
    }

    public function testDestroyNonExistingPropertyReturns404Json(): void
    {
        $res = $this->deleteJson('/api/properties/999999');

        $res->assertNotFound()
            ->assertJson([
                'message' => 'リソースが見つかりません。',
            ]);
    }
}
