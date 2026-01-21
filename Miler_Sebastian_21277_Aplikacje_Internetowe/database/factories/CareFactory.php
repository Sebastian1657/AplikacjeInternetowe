<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Subspecies;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Care>
 */
class CareFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'care_date' => $this->faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'shift' => $this->faker->randomElement([1, 2, 3]),
            'user_id' => User::factory(),
            'subspecies_id' => Subspecies::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
