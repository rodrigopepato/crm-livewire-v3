<?php

namespace Database\Factories;

use App\Traits\Factory\HasDeleted;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpportunityFactory extends Factory
{
    use HasDeleted;

    public function definition(): array
    {
        return [
            'title'  => $this->faker->sentence,
            'status' => $this->faker->randomElement(['open', 'won', 'lost']),
            'amount' => $this->faker->numberBetween(1000, 100000),
        ];
    }
}
