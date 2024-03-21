<?php

namespace Database\Factories;

use App\Models\Admins;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customers>
 */
class CustomersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $last_admin = Admins::latest()->first();

        return [
            'name' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => '(99) 99999-9999',
            'age' => $this->faker->numberBetween(18, 80),
            'gender' => $this->faker->randomElement(['M', 'F', 'N']),
            'admin_id' => $last_admin->id
        ];
    }
}
