<?php

namespace Database\Factories;

use App\Models\Customers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class VehiclesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = Customers::factory()->create();

        return [
            'plate' => 'ABC-1234',
            'brand' => 'Fiat',
            'model' => 'Uno',
            'year' => $this->faker->numberBetween(1950, 2024),
            'color' => 'Preto',
            'steering_system' => 'Direção hidráulica',
            'type_of_fuel' => 'Gasolina',
            'customer_id' => $customer->id
        ];
    }
}
