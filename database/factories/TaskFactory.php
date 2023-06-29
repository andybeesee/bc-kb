<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if($this->faker->boolean()) {
            $name = $this->faker->colorName().' '.random_int(100, 999);
        } elseif($this->faker->boolean()) {
            $name = $this->faker->jobTitle().' '.$this->faker->colorName();
        } else {
            $name = $this->faker->name();
        }
        return [
            'name' => $name,
            'due_date' => $this->faker->boolean(50) ? $this->faker->date() : null,
        ];
    }
}
