<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OpportunityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'  => $this->faker->sentence,
            'status' => $this->faker->randomElement(['open', 'won', 'lost']),
            'amount' => $this->faker->numberBetween(1000, 100000),
        ];
    }
}
