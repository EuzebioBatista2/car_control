<?php

namespace Database\Factories;

use App\Models\Vehicles;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReviewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $vehicles = Vehicles::factory()->create();

        return [
            'vehicle_id' => $vehicles->id,
            'problems' => "Test problem",
            'date_review' => date('Y-m-d H:i:s'),
            'completed' => '0',
        ];
    }
}
