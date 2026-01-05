<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\Meet;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meet>
 */
class MeetFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meet::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lead_id' => function () {
                // Pick an existing lead or create one if none exist
                return Lead::inRandomOrder()->value('id') ?? Lead::factory()->create()->id;
            },
            'staff_id' => function (array $attributes) {
                // Prefer the staff assigned to the selected lead, otherwise pick or create a staff
                $lead = Lead::find($attributes['lead_id']);
                if ($lead && $lead->staff_id) {
                    return $lead->staff_id;
                }

                return Staff::inRandomOrder()->value('id') ?? Staff::create([
                    'staff_code' => 'SEED' . time() . rand(100, 999),
                    'staff_role' => '3',
                    'first_name' => 'Seed',
                    'last_name' => 'User',
                    'email' => 'seed' . time() . '@example.test',
                    'phone' => '0000000000'
                ])->id;
            },
            'meet_title' => $this->faker->sentence(),
            // meeting_type uses numeric codes as strings: '0' - In Person, '1' - Virtual, '2' - Phone
            'meeting_type' => $this->faker->randomElement(['0', '1', '2']),
            'date' => $this->faker->date(),
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->optional()->time(),
            'location' => $this->faker->address(),
            'meeting_link' => $this->faker->optional()->url(),
            'attachment' => $this->faker->imageUrl(),
            'attendees' => [$this->faker->name(), $this->faker->name()],
            'meet_agenda' => $this->faker->sentence(),
            'meeting_notes' => $this->faker->sentence(),
            'follow_up_action' => $this->faker->sentence(),
            // status enum: '0' - Scheduled, '1' - Confirmed, '2' - Completed, '3' - Cancelled, '4' - Rescheduled
            'status' => $this->faker->randomElement(['0', '1', '2', '3', '4']),
        ];
    }
}
