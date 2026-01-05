<?php

namespace Database\Factories;

use App\Models\Engineer;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //
        $usersCount = Staff::count();

        return [
            //
            'staff_id' => function () {
                return Staff::inRandomOrder()->value('id') ?? Staff::create([
                    'staff_code' => 'SEED' . time() . rand(100, 999),
                    'staff_role' => '3',
                    'first_name' => 'Seed',
                    'last_name' => 'User',
                    'email' => 'seed' . time() . '@example.test',
                    'phone' => '0000000000'
                ])->id;
            },
            'lead_number' => 'LEAD' . strtoupper(uniqid()),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => $this->faker->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'dob' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'company_name' => fake()->company(),
            'designation' => fake()->jobTitle(),
            'industry_type' => fake()->randomElement(['pharma', 'school', 'manufacturing']),
            'source' => fake()->randomElement(['referral', 'website', 'call', 'walk-in', 'event']),
            'requirement_type' => fake()->randomElement(['servers', 'cctv', 'biometric', 'networking']),
            'budget_range' => fake()->randomElement(['10K-50K', '50K-100K', '100K-500K', '500K-1000K']),
            'urgency' => fake()->randomElement(['Low', 'Medium', 'High']),
            'status' => fake()->randomElement(['New', 'Contacted', 'Qualified', 'Quoted', 'Lost']),
        ];
    }
}
