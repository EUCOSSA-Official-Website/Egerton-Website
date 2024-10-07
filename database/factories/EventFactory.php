<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a future start time (up to 24 hours from now)
        $startTime = $this->faker->dateTimeBetween('now', '+24 hours');

        // Ensure that the end time is always after the start time
        $endTime = $this->faker->dateTimeBetween($startTime->format('Y-m-d H:i:s'), $startTime->format('Y-m-d H:i:s') . ' +2 hours');

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480, 'events', true),
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'event_day' => $startTime->format('Y-m-d'),
            'speaker' => $this->faker->name,
            'reminder' => $this->faker->boolean,
            'creator_id' => 2,
        ];
    }
}
