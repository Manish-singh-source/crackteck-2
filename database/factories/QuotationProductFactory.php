<?php

namespace Database\Factories;

use App\Models\Quotation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quotation>
 */
class QuotationProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quotationsCount = Quotation::count();

        return [
            //
            'quotation_id' => rand(1, $quotationsCount),
            'product_name' => fake()->sentence(),
            'hsn_code' => fake()->randomNumber(5, true),
            'sku' => fake()->randomNumber(5, true),
            'price' => fake()->randomFloat(2, 10, 1000),
            'quantity' => fake()->randomNumber(2, true),
            'tax' => fake()->randomFloat(2, 0, 10),
            'total' => fake()->randomFloat(2, 10, 1000),
        ];
    }
}
