<?php

namespace Database\Factories;

use App\Models\Subspecies;
use App\Models\Enclosure;
use App\Models\DietPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'birth_date' => $this->faker->dateTimeBetween('-15 years', '-1 month'),
        ];
    }
}
