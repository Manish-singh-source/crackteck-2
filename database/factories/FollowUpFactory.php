<?php

namespace Database\Factories;

use App\Models\Engineer;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FollowUp>
 */
class FollowUpFactory extends Factory
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
            // 'lead_id' => Lead::inRandomOrder()->first()->id,
            // 'client_name' => function (array $attributes) {
            //     return Lead::find($attributes['lead_id'])->first_name . ' ' . Lead::find($attributes['lead_id'])->last_name;
            // },
            // 'contact' => function (array $attributes) {
            //     return Lead::find($attributes['lead_id'])->phone;
            // },
            // 'email' => function (array $attributes) {
            //     return Lead::find($attributes['lead_id'])->email;
            // },
            'followup_date' => fake()->date(),
            'followup_time' => fake()->time(),
            'status' => fake()->randomElement(['Pending', 'Done', 'Rescheduled', 'Cancelled']),
            'remarks' => fake()->jobTitle(),
        ];
    }
}
