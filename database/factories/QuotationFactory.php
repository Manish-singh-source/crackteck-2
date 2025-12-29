<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quotation>
 */
class QuotationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $leadsCount = Lead::count();

        return [
            //
            'lead_id' => rand(1, $leadsCount),
            'quote_id' => 'Q-'.str_pad(rand(1, 1000), 5, '0', STR_PAD_LEFT),
            'quote_date' => fake()->date(),
            'expiry_date' => fake()->date(),
        ];
    }
}
