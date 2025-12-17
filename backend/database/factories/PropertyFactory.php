<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    protected $model = Property::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'サンプル物件' . $this->faker->randomElement(['A','B','C']),
            'is_corner' => $this->faker->boolean(),
            'distance_convenience_store' => $this->faker->numberBetween(50, 800),
            'sunlight_score' => $this->faker->numberBetween(1, 5),
            'noise_score' => $this->faker->numberBetween(1, 5),
        ];
    }
}
