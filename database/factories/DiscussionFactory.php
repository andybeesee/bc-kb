<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discussion>
 */
class DiscussionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if($this->faker->boolean()) {
            $subject = $this->faker->colorName().' '.random_int(9999, 99999);
        } else if($this->faker->boolean()) {
            $subject = $this->faker->sentence();
        } else {
            $subject = $this->faker->title().' '.$this->faker->jobTitle();
        }

        return [
            'subject' => $subject
        ];
    }
}
