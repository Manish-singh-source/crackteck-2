<?php

namespace Database\Factories;

use App\Models\Quotation;
use App\Models\QuotationProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuotationProduct>
 */
class QuotationProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuotationProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 10);
        $unitPrice = $this->faker->randomFloat(2, 10, 100);
        $discount = $this->faker->randomFloat(2, 0, 5);
        $tax = $this->faker->randomFloat(2, 0, 18);

        return [
            'quotation_id' => function () {
                return Quotation::inRandomOrder()->value('id') ?? Quotation::factory()->create()->id;
            },
            'product_name' => $this->faker->words(3, true),
            'hsn_code' => $this->faker->optional()->bothify('#######'),
            'sku' => $this->faker->optional()->bothify('SKU-###'),
            'product_description' => $this->faker->optional()->sentence(),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount_per_unit' => $discount,
            'tax_rate' => $tax,
            'line_total' => round($quantity * ($unitPrice - $discount) * (1 + $tax / 100), 2),
            'sort_order' => 0,
        ];
    }
}
