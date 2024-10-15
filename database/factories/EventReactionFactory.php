<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventReaction>
 */
class EventReactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Hard-code user_id and event_id
            'user_id' => 1,  // Assuming user with ID 1 exists
            'event_id' => 19, // Assuming event with ID 12 exists

            // Randomly choose between 'like' or 'dislike'
            'reaction' => $this->faker->randomElement(['like', 'dislike']),
        ];
    }
}
