<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\Staff;
use App\Models\FollowUp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FollowUp>
 */
class FollowUpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FollowUp::class;

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
            'followup_date' => $this->faker->date(),
            'followup_time' => $this->faker->time(),
            'followup_type' => $this->faker->randomElement(['0', '1', '2', '3']),  // enum uses numeric codes as strings: '0' - Call, '1' - Email, '2' - Meeting, '3' - SMS
            // enum uses numeric codes as strings: '0' - Pending, '1' - Completed, '2' - Rescheduled, '3' - Cancelled
            'status' => $this->faker->randomElement(['0', '1', '2', '3']),
            'remarks' => $this->faker->sentence(),
        ];
    }
}
