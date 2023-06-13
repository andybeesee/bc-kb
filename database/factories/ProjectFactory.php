<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->boolean() ? $this->faker->colorName().' '.$this->faker->words(3, true) : $this->faker->name().' '.$this->faker->date(),
            'due_date' => $this->faker->boolean(50) ? $this->faker->date() : null,
        ];
    }
}
