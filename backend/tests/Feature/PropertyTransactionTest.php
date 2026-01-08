<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use RuntimeException;

class PropertyTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function testWithoutTransactionLeavesRecord(): void
    {
        $service = app(\App\Services\PropertyService::class);

        try {
            $service->createWithMultipleStepsWithoutTransaction([
                'name' => 'TEST',
                'is_corner' => true,
                'sunlight_score' => 3,
            ]);
        } catch (RuntimeException $e) {
            // 何もしない（例外を受け取るだけ）
        }

        // DBに残ってしまっている
        $this->assertDatabaseHas('properties', [
            'name' => 'TEST_UPDATED',
        ]);
    }

    public function testWithTransactionRollsBack(): void
    {
        $service = app(\App\Services\PropertyService::class);

        try {
            $service->createWithMultipleStepsWithTransaction([
                'name' => 'TEST',
                'is_corner' => true,
                'sunlight_score' => 3,
            ]);
        } catch (RuntimeException $e) {
            // OK
        }

        // 何も保存されない
        $this->assertDatabaseMissing('properties', [
            'name' => 'TEST_UPDATED',
        ]);
    }
}
