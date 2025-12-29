<?php

namespace Database\Factories;

use App\Models\Engineer;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meet>
 */
class MeetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $leadsCount = Lead::count();
        $usersCount = Engineer::count();

        return [
            //
            'lead_id' => rand(1, $leadsCount),
            'user_id' => rand(1, $usersCount),
            'meet_title' => fake()->jobTitle(),
            'meeting_type' => fake()->randomElement(['Onsite Demo', 'Virtual Meeting', 'Technical Visit', 'Business Meeting']),
            'date' => fake()->date(),
            'time' => fake()->time(),
            'meetAgenda' => fake()->sentence(),
            'followUp' => fake()->sentence(),
            'location' => fake()->address(),
            'attachment' => fake()->imageUrl(),
            'status' => fake()->randomElement(['Scheduled', 'Confirmed', 'Completed', 'Cancelled']),
        ];
    }
}
