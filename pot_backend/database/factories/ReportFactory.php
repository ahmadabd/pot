<?php

namespace Database\Factories;

use App\Models\Flower;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'flower_id' => Flower::factory()->create()->id,
            'height' => $this->faker->randomFloat(2, 0, 10),
            'temperature' => $this->faker->randomFloat(2, 0, 10),
            'humidity' => $this->faker->randomFloat(2, 0, 10),
        ];
    }
}
