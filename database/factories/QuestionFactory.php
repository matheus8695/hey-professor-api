<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'  => User::factory(),
            'question' => $this->faker->sentence . '?',
            'status'   => 'draft',
        ];
    }

    public function published(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
        ]);
    }

    public function draft(): self
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
        ]);
    }
}
