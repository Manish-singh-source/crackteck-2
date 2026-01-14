<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\Staff;
use App\Models\Quotation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quotation>
 */
class QuotationFactory extends Factory
{
    
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Quotation::class;

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
                    'staff_role' => 'sales_person',
                    'first_name' => 'Seed',
                    'last_name' => 'User',
                    'email' => 'seed' . time() . '@example.test',
                    'phone' => '0000000000'
                ])->id;
            },
            'quote_id' => 'QUO' . strtoupper(uniqid()),
            'quote_number' => 'QUO' . strtoupper(uniqid()),
            'quote_date' => $this->faker->date(),
            'expiry_date' => $this->faker->date(),
            'total_items' => $this->faker->numberBetween(1, 100),
            'currency' => $this->faker->currencyCode(),
            'subtotal' => $this->faker->randomFloat(2, 100, 1000),
            'discount_amount' => $this->faker->randomFloat(2, 0, 100),
            'tax_amount' => $this->faker->randomFloat(2, 0, 100),
            'total_amount' => $this->faker->randomFloat(2, 100, 1000),
            'status' => $this->faker->randomElement(['draft', 'sent', 'accepted', 'rejected', 'expired', 'converted']),
            'terms_conditions' => $this->faker->paragraph(),
            'notes' => $this->faker->paragraph(),
            'sent_at' => $this->faker->optional()->date(),
            'accepted_at' => $this->faker->optional()->date(),
            'quote_document_path' => $this->faker->optional()->imageUrl(),

        ];
    }
}
