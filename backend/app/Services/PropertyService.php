<?php

namespace App\Services;

class PropertyService
{
    public function list(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'サンプル物件A',
                'is_corner' => true,
                'distance_convenience_store' => 120,
                'sunlight_score' => 4,
                'noise_score' => 2,
            ],
        ];
    }
}
