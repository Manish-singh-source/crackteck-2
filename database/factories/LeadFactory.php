<?php

namespace Database\Factories;

use App\Models\Engineer;
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
        $usersCount = Engineer::count();

        return [
            //
            'user_id' => rand(1, $usersCount),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => $this->faker->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'dob' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female']),
            'company_name' => fake()->company(),
            'designation' => fake()->jobTitle(),
            'industry_type' => fake()->randomElement(['pharma', 'school', 'manufacturing']),
            'source' => fake()->randomElement(['referral', 'website', 'walk_in', 'event']),
            'requirement_type' => fake()->randomElement(['servers', 'cctv', 'biometric', 'networking']),
            'budget_range' => fake()->randomElement(['10K-50K', '50K-100K', '100K-500K', '500K-1000K']),
            'urgency' => fake()->randomElement(['Low', 'Medium', 'High']),
            'status' => fake()->randomElement(['New', 'Contacted', 'Qualified', 'Quoted', 'Lost']),
        ];
    }
}
